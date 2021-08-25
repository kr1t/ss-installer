<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerPoint;
use App\EngineerRedeem;
use App\RedeemPoint;
use App\Exports\RedeemExport;
use App\Http\Requests\EngineerRedeemRequest;
use App\RedeemItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RedeemController extends Controller
{

    public function getUserPoint(Request $request, $line_uid)
    {
        $line_uid = $line_uid;
        $engineer = Engineer::where('line_uid', $line_uid)->first();
        if (!$engineer) {
            return ["status" => 400, "message" => "User Not Found"];
        }
        return ["status" => 200, "message" => "Success", "engineer" => [
            "engineer_code" => $engineer->installer_id,
            "first_name" => $engineer->first_name_th,
            "last_name" => $engineer->last_name_th,
            "line_uid" => $engineer->line_uid,
            "point" => $engineer->total * 1,
            "province" => $engineer->province
        ]];
    }
    public function getInstaller(Request $request)
    {
        // $line_uid = 'u12354654654'; //get line user id

        $line_uid = $request->line_uid;

        $engineer = Engineer::where('line_uid', $line_uid)->first();

        if (empty($engineer)) {
            $registered = false;
            $hasId = false;
        } else {
            $registered = true;
            $hasId = empty($engineer->installer_id) ? false : true;
        }

        return [
            'registered' => $registered,
            'hasId' => $hasId
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        //         $line_uid = 'u12354654654'; //get line user id TEMPORARY

        $line_uid = $request->line_uid;

        $engineer = Engineer::where('line_uid', $line_uid)->with([
            'points' => function ($q) {
                $q->orderBy('created_at', 'desc');
            },
        ])->get()->first();

        if (empty($engineer))
            return redirect('/register');

        if (empty($engineer->installer_id))
            return view('frontend.error')->with('message', 'โปรดรอยืนยันการลงทะเบียน');


        $redeemItems = RedeemItem::all();

        $start_date = '2021-07-30 00:00:00';
        $end_date = Carbon::now()->format('Y-m-d H:i:s');



        $apiGetPoints = $this->updatePoint($engineer->installer_id, $start_date, $end_date);


        if ($request->test) {
            return $apiGetPoints;
        }
        foreach ($apiGetPoints as $point) {
            if ($point['jobs_status'] == 1) {
                // Check By ID
                $findReedeemPoint = RedeemPoint::select('id')->where('job_id', $point['job_id'])->where("engineer_id", $engineer->id)->first();
                if (!$findReedeemPoint) {
                    RedeemPoint::create([
                        "job_id" => $point['job_id'],
                        "jobs_create_date" => $point['jobs_create_date'],
                        "jobs_update_date" => $point['jobs_Update_date'],
                        "point" => $point['point'],
                        "engineer_id" => $engineer->id,
                    ]);
                    EngineerPoint::create([
                        'engineer_id' => $engineer->id,
                        "point" => $point['point']
                    ]);
                }
            }
        }

        return view('frontend.redeem', compact('engineer', 'redeemItems', 'line_uid'));
    }

    public function getToken()
    {
        try {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.ss-swatinhome.com/installer-service/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_POSTFIELDS => 'grant_type=password&line_id=eng_sync_not_remove',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);


            return json_decode($response, true)['access_token'];
        } catch (\Exception $e) {
            return [];
        }
    }


    public function updatePoint($code_engineer, $start_date, $end_date)
    {
        try {
            $token = $this->getToken();
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.ss-swatinhome.com/installer-service/api/member/jobs_point',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "code_engineer" => $code_engineer,
                    "start_date" => $start_date,
                    "end_date" => $end_date,
                    "size" => 500,
                ]),
                CURLOPT_HTTPHEADER => array(
                    "Authorization: bearer {$token}",
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            if (request()->test) {
                return [
                    "request" => [
                        "code_engineer" => $code_engineer,
                        "start_date" => $start_date,
                        "end_date" => $end_date,
                        "size" => 500,
                    ],
                    "response" => json_decode($response, true)
                ];
            }

            return json_decode($response, true)['Result'];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Engineer $engineer, RedeemItem $item, $name, Request $request)
    {

        $line_uid = $request->line_uid;
        if ($engineer->total >= $item->redeem_point)
            return view('frontend.redeem-item', compact('item', 'engineer', 'line_uid'));

        return redirect('/call/redeem');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EngineerRedeemRequest $request)
    {
        $request->validated();
        $engineer_redeem_id = EngineerRedeem::create($request->all())->id;
        $log_point = $request->all();
        $log_point['engineer_redeem_id'] = $engineer_redeem_id;
        EngineerPoint::create($log_point);

        return redirect('/call/redeem');
    }

    public function export()
    {
        return view('admin.redeem.export');
    }

    public function exportSubmit(Request $request)
    {
        return Excel::download(new RedeemExport, 'redeem-' . time() . '.xlsx');
    }
}
