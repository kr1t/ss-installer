<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerPoint;
use App\Imports\EngineerImport;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

use Helpers\LineBot;

class AdminController extends Controller
{
    public function export()
    {
        return view('admin.engineer.export');
    }
    public function import()
    {
        $engineers = [];
        return view('admin.engineer.import', compact('engineers'));
    }

    public function multicastByTel()
    {
        return view('admin.multicast.tel');
    }


    public function sendMulticastByTel(Request $request)
    {

        $tels = explode(",", $request->tels);

        foreach ($tels as $tel) {
            $engineer = Engineer::where('tel', $tel)->first();

            $bot = new LineBot(env('LINE_TOKEN', ''));
            $success = [];
            $fail = [];
            try {

                $bot->setUser($engineer->line_uid)->addText($request->message)->push();

                if (isset($pushAPI['message'])) {
                    array_push($fail, $engineer);
                } else {
                    $engineer->increment('notification_count');
                    array_push($success, $engineer);
                }
            } catch (\Exception $e) {
                array_push($fail, $engineer);
            }
        }

        return redirect(url('admin/installer/multicast/tel'))->with('success', $success)->with('fail', $fail);
    }

    public function importPoint()
    {
        if (!empty(request()->file('file'))) {
            $pointImports = Excel::toArray(new PointsImport, request()->file('file'));
            $points = $pointImports[0];

            return view('admin.point.import', compact('points'));
        }

        return redirect('/admin/point/import');
    }

    public function importPointSubmit(Request $request)
    {
        $points = json_decode($request->points, true);
        $import = $request->import;

        $success = [];
        $fail = [];

        foreach ($points as $point) {
            $engineer = Engineer::where('installer_id', $point['engineer_code'])->first(['id']);
            if ($engineer != null) {
                $input['engineer_id'] = $engineer->id;
                $input['point'] = $point['point'];
                $input['created_at'] = date('Y-m-d H:m:s', strtotime($point['job_source_create']));
                $input['updated_at'] = date('Y-m-d H:m:s', strtotime($point['job_source_update']));
                EngineerPoint::create($input);
                array_push($success, $point);
            } else {
                array_push($fail, $point);
            }
        }

        return redirect('/admin/point/import')->with('success', $success)->with('fail', $fail);
    }
}
