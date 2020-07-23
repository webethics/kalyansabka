<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserBankDetailsRequest extends FormRequest
{
   

    public function rules()
    {
		
		 return [
			'account_number'     => [
				'required',
			],
			'account_name'    => [
				'required',
			],
			'ifsc_code'   => [
			   'required',
			], 
			'bank_name'   => [
			   'required',
			], 
			
		   
		];
		
       
    }
	
	 public function messages()
    {
        return [
            'mobile_number.regex' => 'Your Mobile Number should be minimum 9 digits.',
            'mobile_number.min' => 'fhfgs.',
        ];
    }
	
	
}
