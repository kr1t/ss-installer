<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EngineerRedeemRequest extends FormRequest
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
            'engineer_id',
            'name',
            'address',
            'tel',
            'redeem_item_id'
        ];
    }
}
