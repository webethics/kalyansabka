<?php
namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CreateCustomerRequest extends FormRequest
{
   /*  public function authorize()
    {
        return \Gate::allows('user_create');
    }
 */
    public function rules(Request $request)
    {
		$request->aadhar_number = str_replace('-','',$request->aadhar_number);
		
        return [
            'first_name'     => [
                'required',
            ],
			 'last_name'     => [
                'required',
            ],
			'email*' => [
				'required','email','unique:users'
			],
            'mobile_number'   => [
               'required','unique:users','numeric','regex:/[0-9]{9}/',
            ],
            'aadhar_number'   => [
               'required','unique:users',
            ], 
			'address'   => [
               'required',
            ], 
			'role_id'   => [
               'required',
            ], 
			
        ];
    }
	public function messages()
    {
		return [
          /* 'password.regex' => 'Your password must contain 1 lower case character 1 upper case character one number and One special character.', */
		  'mobile_number.regex' => 'Your Mobile Number should be minimum 9 digits.',
          'mobile_number.min' => 'fhfgs.',
		  'login_password.regex' => 'Your password must contain 1 lower case character 1 upper case character one number and One special character.',
        ];
			 
    }
	
}
