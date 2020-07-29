<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserNomineeDetailsRequest extends FormRequest
{
   

    public function rules()
    {
		//echo '<pre>';print_r($this->request->get('nominee_number'));die;
		$return = [];
		$return =  [
			'nominee_number'     => [
				'required',
			],
		];
		$data['nominee_number']  = $this->request->get('nominee_number');
		if($data['nominee_number'] == 1){
			$return['nominee_name_1'] = [
					'required',
				];
			$return['nominee_relation_1'] = [
					'required',
				];
		}
		
		if($data['nominee_number'] == 2){
			$return['nominee_name_1'] = [
					'required',
				];
				
			$return['nominee_name_2'] = [
					'required',
				];
			$return['nominee_relation_1'] = [
					'required',
				];
				
			$return['nominee_relation_2'] = [
					'required',
				];
		}
		if($data['nominee_number'] == 3){
			
			$return['nominee_name_1'] = [
					'required',
				];
				
			$return['nominee_name_2'] = [
					'required',
				];
			$return['nominee_name_3'] = [
					'required',
				];
			$return['nominee_relation_1'] = [
					'required',
				];
				
			$return['nominee_relation_2'] = [
					'required',
				];
			$return['nominee_relation_3'] = [
					'required',
				];
		}
		if($data['nominee_number'] == 4){
			$return['nominee_name_1'] = [
					'required',
				];
				
			$return['nominee_name_2'] = [
					'required',
				];
			$return['nominee_name_3'] = [
					'required',
				];
			$return['nominee_name_4'] = [
					'required',
				];
			$return['nominee_realtion_1'] = [
					'required',
				];
				
			$return['nominee_realtion_2'] = [
					'required',
				];
			$return['nominee_realtion_3'] = [
					'required',
				];
			$return['nominee_realtion_4'] = [
					'required',
				];
		}
		
		
		return $return;
       
    }
	
	 public function messages()
    {
        return [
            'mobile_number.regex' => 'Your Mobile Number should be minimum 9 digits.',
            'mobile_number.min' => 'fhfgs.',
			'nominee_name_*.required' => 'The Nominee Name field required.',
			'nominee_relation_*.required' => 'The Nominee relation field required.',
        ];
    }
	
	
}
