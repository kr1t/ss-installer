<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'engineer_id' => 'required',
            'exam_type' => 'required',
            'answer_1' => 'required',
            'answer_2' => 'required',
            'answer_3' => 'required',
            'answer_4' => 'required',
            'answer_5' => 'required',
            'answer_6' => 'required',
            'answer_7' => 'required',
            'answer_8' => 'required',
            'answer_9' => 'required',
            'answer_10' => 'required',
            'answer_11' => 'required',
            'answer_12' => 'required',
            'answer_13' => 'required',
            'answer_14' => 'required',
            'answer_15' => 'required',
            'answer_16' => 'required',
            'answer_17' => 'required',
            'answer_18' => 'required',
            'answer_19' => 'required',
            'answer_20' => 'required',
        ];
    }
}
