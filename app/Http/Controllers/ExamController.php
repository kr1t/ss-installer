<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerAnswer;
use App\EngineerExam;
use App\EngineerPoint;
use App\ExamPermission;
use App\Http\Requests\AnswerRequest;
use App\Imports\ExamPermissionImport;
use App\Imports\PointsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExamController extends Controller
{
    public function exam(Request $request, string $type)
    {
        $line_uid = $request->line_uid; //get line user id

        $engineer = (Engineer::where('line_uid', $line_uid)->first(['id']));
        $engineer_id = $engineer->id;

        $permission = ExamPermission::where('engineer_id', $engineer_id)
            ->where('level', $type)
            ->latest()->first();

<<<<<<< HEAD
        if($permission) {
            ($permission->type == 'silver' ? $engineer_level = 1 : $engineer_level = 2); // $engineer->level ; 1 silver, 2 gold
=======
        $errorMsg = '';
        if ($type == 'silver')
            $type = 1;
        else if ($type == 'gold')
            $type = 2;
        else
            $errorMsg = 'ไม่พบหน้าที่ค้นหา';
>>>>>>> c9de6ac63f55d9194d003c1c0a55edc21b9d02c2

            $errorMsg = '';
            if($type == 'silver')
                $type = 1;
            else if($type == 'gold')
                $type = 2;
            else
                $errorMsg = 'ไม่พบหน้าที่ค้นหา';

            if ($engineer_level != $type)
                $errorMsg = 'ระดับไม่ถูกต้อง';

            if (!empty($errorMsg)) {
                return view('frontend.error')->with('message', $errorMsg);
            }

<<<<<<< HEAD
            $isSubmit = EngineerAnswer::where('engineer_id', $engineer_id)
                ->where('exam_type', $type)
                ->first(['id']);

            if($isSubmit == null && $engineer_level == $type) {
                $jquery_exams = EngineerExam::where('type', $type)->get(['title', 'choice_1', 'choice_2', 'choice_3', 'choice_4']);
                $exams = [];
                foreach ($jquery_exams as $exam) {
                    $shuffle = [
                        'title' => $exam->title,
                        'choices' => collect([$exam->choice_1, $exam->choice_2, $exam->choice_3, $exam->choice_4])->shuffle(),
                    ];
                    array_push($exams,$shuffle);
                }

                return view('frontend.exam', compact('exams', 'engineer_id', 'type'));
=======
        if ($isSubmit == null && $engineer_level == $type) {
            $jquery_exams = EngineerExam::where('type', $type)->get(['title', 'choice_1', 'choice_2', 'choice_3', 'choice_4']);
            $exams = [];
            foreach ($jquery_exams as $exam) {
                $shuffle = [
                    'title' => $exam->title,
                    'choices' => collect([$exam->choice_1, $exam->choice_2, $exam->choice_3, $exam->choice_4])->shuffle(),
                ];
                array_push($exams, $shuffle);
>>>>>>> c9de6ac63f55d9194d003c1c0a55edc21b9d02c2
            }

            return view('frontend.success-exam-ag');
        } else {
            return view('frontend.error')->with('message', 'ไม่มีสิทธิ์ทำข้อสอบ');
        }
    }

    public function store(AnswerRequest $request)
    {
        $request->validated();
        $input = $request->all();
        $type = $input['exam_type'];

        $isSubmit = EngineerAnswer::where('engineer_id', $input['engineer_id'])
            ->where('exam_type', $type)
            ->first(['id']);

        if ($isSubmit == null) {
            $correct_choices = (EngineerExam::where('type', $type)->get(['correct_choice']));

            $score = 0;
            foreach ($correct_choices as $key => $c) {
                if ($input['answer_' . ($key + 1)] == $c->correct_choice)
                    $score += 1;
            }

            $input['score'] = $score;

            EngineerAnswer::create($input);
            $permission = ExamPermission::where('engineer_id', $input['engineer_id'])->latest()->first();

            $permission->update(['status'=>'done']);

            return view('frontend.success-exam');
        }

        return view('frontend.success-exam-ag');
    }


    public function importSilver()
    {
        if(!empty(request()->file('file'))){
            $permissionImports = Excel::toArray(new ExamPermissionImport, request()->file('file'));
            $permissions = [];
            foreach ($permissionImports[0] as $permission){
                ($permission['engineer_code']) ? array_push($permissions, $permission) : '';
            }

            return view('admin.permission.silver-import', compact('permissions'));
        }

        return redirect('/admin/permission/silver-import');
    }

    public function importSilverSubmit(Request $request)
    {
        $permissions = json_decode($request->permissions, true);
        $import = $request->import;

        $success = [];
        $fail = [];

        foreach ($permissions as $permission){
            $engineer = Engineer::where('installer_id', $permission['engineer_code'])->first(['id']);
            if ($engineer != null){
                $input['engineer_id'] = $engineer->id;
                $input['level'] = 'silver';
                ExamPermission::create($input);
                array_push($success, $permission);
            } else {
                array_push($fail, $permission);
            }
        }

        return redirect('/admin/permission/silver-import')->with('success', $success)->with('fail', $fail);

    }


    public function importGold()
    {
        if(!empty(request()->file('file'))){
            $permissionImports = Excel::toArray(new ExamPermissionImport, request()->file('file'));
            $permissions = [];
            foreach ($permissionImports[0] as $permission){
                ($permission['engineer_code']) ? array_push($permissions, $permission) : '';
            }

            return view('admin.permission.gold-import', compact('permissions'));
        }

        return redirect('/admin/permission/gold-import');
    }

    public function importGoldSubmit(Request $request)
    {
        $permissions = json_decode($request->permissions, true);
        $import = $request->import;

        $success = [];
        $fail = [];

        foreach ($permissions as $permission){
            $engineer = Engineer::where('installer_id', $permission['engineer_code'])->first(['id']);
            if ($engineer != null){
                $input['engineer_id'] = $engineer->id;
                $input['level'] = 'gold';
                ExamPermission::create($input);
                array_push($success, $permission);
            } else {
                array_push($fail, $permission);
            }
        }

        return redirect('/admin/permission/gold-import')->with('success', $success)->with('fail', $fail);

    }
}
