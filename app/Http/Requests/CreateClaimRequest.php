<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClaimRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => [
                'required',
            ],
            'aadhar_number'     => [
                'required',
            ],
            'mobile_number'    => [
                'required','numeric','regex:/[0-9]{10}/',
            ],
            'initimation_mobile_number'   => [
               'required','numeric','regex:/[0-9]{10}/',
            ],
            'initimation_aadhar_number'   => [
               'required_without:policy_number',
            ],
            'policy_number'   => [
               'required_without:initimation_aadhar_number',
            ],
            'document'     => [
                'required',
            ],
        ];
    }
}
