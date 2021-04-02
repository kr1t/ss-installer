<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerPoint;
use App\EngineerRedeem;
use App\Exports\RedeemExport;
use App\Http\Requests\EngineerRedeemRequest;
use App\RedeemItem;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RedeemController extends Controller
{
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

        return view('frontend.redeem', compact('engineer', 'redeemItems', 'line_uid'));
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
