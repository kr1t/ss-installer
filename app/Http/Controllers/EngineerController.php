<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerPoint;
use App\Imports\EngineerImport;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;

class EngineerController extends Controller
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

    public function importPoint()
    {
        if(!empty(request()->file('file'))){
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

        foreach ($points as $point){
            $engineer = Engineer::where('installer_id', $point['engineer_code'])->first(['id']);
            if ($engineer != null){
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
