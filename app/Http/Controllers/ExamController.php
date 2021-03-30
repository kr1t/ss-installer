<?php

namespace App\Http\Controllers;

use App\Engineer;
use App\EngineerAnswer;
use App\EngineerExam;
use App\Http\Requests\AnswerRequest;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function exam(string $type)
    {
        $line_uid = 'u12354654654'; //get line user id
        $engineer = (Engineer::where('line_uid', $line_uid)->first(['id']));
        $engineer_id = $engineer->id;

        $engineer_level = 1; // $engineer->level ; 1 silver, 2 gold

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
        }

        return view('frontend.success-exam-ag');
    }

    public function store(AnswerRequest $request)
    {
        $request->validated();
        $input = $request->all();
        $type = $input['exam_type'];

        $isSubmit = EngineerAnswer::where('engineer_id', $input['engineer_id'])
            ->where('exam_type', $type)
            ->first(['id']);

        if($isSubmit == null) {
            $correct_choices = (EngineerExam::where('type', $type)->get(['correct_choice']));

            $score = 0;
            foreach ($correct_choices as $key=>$c) {
                if($input['answer_'.($key+1)] == $c->correct_choice)
                    $score += 1;
            }

            $input['score'] = $score;

            EngineerAnswer::create($input);

            return view('frontend.success-exam');
        }

        return view('frontend.success-exam-ag');
    }
}
