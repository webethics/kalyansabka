<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class UpdateWithdawalRequest extends FormRequest
{
   /*  public function authorize()
    {
        return \Gate::allows('user_create');
    }
 */
    public function rules()
    {
        return [
		
            'deduction_type'     => [
                'required',
            ],
			'tds_deduction_amount'     => [
                'required_if:deduction_type,==,amount',
            ],
			'tds_deduction_percentage'     => [
                'required_if:deduction_type,==,percentage',
            ],
			 'admin_charges'     => [
                'required',
            ]
		];
    }
	public function messages()
    {
		return [
          /* 'password.regex' => 'Your password must contain 1 lower case character 1 upper case character one number and One special character.', */
		  'tds_deduction_amount.required_if' => 'TDS Deduction amount is required',
          'tds_deduction_percentage.required_if' => 'TDS Deduction percentage is required',
		  'login_password.regex' => 'Your password must contain 1 lower case character 1 upper case character one number and One special character.',
        ];
			 
    }
	
}
