<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserBankDetailsRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Requests\UpdateBasicUserRequest;
use App\Models\UserBankDetails;
use App\Models\UserDocuments;
use App\Http\Requests\sendEmailNotification;
use App\Http\Requests\ResetPassword;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\CdrGroup;
use App\Models\EmailTemplate;
use App\Models\TempRequestUser;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class UsersController extends Controller
{
	//Records per page 
	protected $per_page;
	private $qr_code_path;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function landing_page()
    {
       return view('users.users.landing');
		
		//return view('users.account.account');
    }
    public function ajaxPagination(Request $request)
    {
	
		//USER/ANALYST NOT ABLE TO ACCESS THIS 
		access_denied_user_analyst();
		
		$request->role_id = 2;
        $users= $this->advance_search($request,'');
		$roles = Role::all();
        if(!is_object($users)) return $users;
        if ($request->ajax()) {
            return view('users.users.usersPagination', compact('users','roles'));
        }
        return view('users.users.index',compact('users','roles'));	
	}
	
	// ROLE DROPDOWN AJAX OPTION ON CREATE USER FORM 
    public function roleDropdown(Request $request)
    {
		if($request->ajax()){
			$request->group_id;
			$roles = Role::where('group_id',$request->group_id)->get();
			return view('users.users.role_dropdown',compact('roles'));
		}
	
    }
	
	// City DROPDOWN AJAX OPTION ON CREATE USER FORM 
    public function cityDropdown(Request $request)
    {
		
		if($request->ajax()){
			$request->state_id;
			$cities = CityLists::where('state_id',$request->state_id)->get();
			return view('auth.city_dropdown',compact('cities'));
		}
	
    }
	// Refered aadhaar verification 
    public function verifiedAadhar(Request $request)
    {
		
		if($request->ajax()){
			$request->aadhar_number = str_replace('-','',$request->aadhar_number);
			$user_data = User::where('aadhar_number',$request->aadhar_number)->orWhere('mobile_number',$request->aadhar_number)->first();
			$data = array();
			
			if($user_data){
				$data['success'] = true;
				$data['name'] = $user_data->first_name.' '.$user_data->last_name;
			}else{
				$data['success'] = false;
			}
			return json_encode($data);die;
		}
	
    }
	// CALCULATE AGE AJAX OPTION ON CREATE USER FORM 
    public function calculateAge(Request $request)
    {
		
		if($request->ajax()){
			
			
			// Creating timestamp from given date
			/* $timestamp = strtotime($request->date_of_birth);
			 
			// Creating new date format from that timestamp
			//$new_date = date("d-m-Y", $timestamp);
			echo $new_date;die;  */
			
			$dob = new DateTime($request->date_of_birth);
			
			
			//We need to compare the user's date of birth with today's date.
			$now = new DateTime();
			 
			//Calculate the time difference between the two dates.
			$difference = $now->diff($dob);
			 
			//Get the difference in years, as we are looking for the user's age.
			$age = $difference->y; 
			
			if($age){
				$price = '';	
				$htmldata = '';
				if($age >= 21 && $age <= 40){
					$price = 2500;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="2500" /> <span>2500(2 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="6000" /> <span>6000(6 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="10000" /> <span>10000(10 Lakh)</span></label>';
				}
				if($age >= 41 && $age <= 45){
					$price = 3000;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="3000" /> <span>2500(3 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="7000" /> <span>6000(7 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="11000" /> <span>10000(11 Lakh)</span></label>';
				}
				if($age >= 46 && $age <= 50){
					$price = 3500;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="3500" /> <span>3500(4 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="8000" /> <span>6000(8 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="12000" /> <span>10000(12 Lakh)</span></label>';
				}
				if($age >= 51 && $age <= 55){
					$price = 4000;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="4000" /> <span>4000(5 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="9000" /> <span>6000(9 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="13000" /> <span>10000(13 Lakh)</span></label>';
				}
				if($age >= 56 && $age <= 60){
					$price = 4500;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="4500" /> <span>4500(6 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="10000" /> <span>6000(10 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="14000" /> <span>10000(14 Lakh)</span></label>';
				}
				if($age >= 61 && $age <= 65){
					$price = 5000;
					$htmldata = '
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="5000" /> <span>5000(7 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="11000" /> <span>6000(11 Lakh)</span></label>
						<label class="radio-inline ml-3"><input type="radio" name="amount" class="" value="15000" /> <span>150000(15 Lakh)</span></label>';
				}
				//Print it out.
				$data = array();
				$data['success'] = true;
				$data['age'] = $age;
				$data['price'] = $price;
				$data['htmldata'] = $htmldata;
				return json_encode($data);die;
			}else{
				$data = array();
				
				$data['age'] =false;
				return json_encode($data);die;
			}
			
		}
	
    }
	
   
/*==================================================
	 SHOW USER PROFILE 
==================================================*/ 
	public function account()
    {
        $user = user_data();
		$user_id = $user->id;
		$bank_detais = UserBankDetails::where('user_id',$user_id)->first();
		$document_details = UserDocuments::where('user_id',$user_id)->first();
		return view('users.account.account', compact('user','bank_detais','document_details'));
		//return view('users.account.account');
    }
	
/*==================================================
	 SHOW USER PROFILE 
==================================================*/ 
	public function edit($user_id)
    {
		
        $user = User::where('id',$user_id)->get();
		$roles = Role::all();
		if(count($user)>0){
			$user =$user[0];
			$user->qr_code = '<a href="'.url('customer-info').'/'.$user_id.'">Open Link</a>';
			$view = view("modal.userEdit",compact('user','roles'))->render();
			$success = true;
		}else{
			$view = '';
			$success = false;
		}
		
        //abort_unless(\Gate::allows('request_edit'), 403);
		
		return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	

	
/*==================================================
	  UPDATE USER PROFILE 
==================================================*/  
	public function profileUpdate(UpdateUserRequest $request,$user_id)
    {
		$data=array();
		 $result =array();
		//pr($request->all());
		 $requestData = User::where('id',$user_id);
		 $stored_data = User::where('id',$user_id)->first()->toArray();
		 
		if($request->ajax()){
			$data =array();
			$data['business_name']= $request->business_name;
			$data['owner_name']= $request->owner_name;
			$data['mobile_number'] = $request->mobile_number;
			$data['business_url'] = $request->business_url;
			$data['address'] = $request->address;
			
			$requestData->update($data);
			
			//UPDATE PROFILE EVENT LOG END  
		   $result['success'] = true;
		   $result['name'] = $request->owner_name;
		   $result['mobile_number'] = $request->mobile_number;
		   $result['business_name']= $request->business_name;
		   $result['business_url']= $request->business_url;
		   
		   return Response::json($result, 200);
		}
		
    }


    public function updateBasicProfile(UpdateBasicUserRequest $request,$user_id){
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
    	if(!empty($user_id)){
    		//Check if valid user id
    		$user = User::find($user_id);
    		if(!is_null($user->count())){
    			$tempUser = TempRequestUser::where('user_id',$user_id)->where('status',0)->first();
    			//check if pending request table exist
    			if(!is_null($tempUser))
    				$tempRequest = TempRequestUser::find($tempUser->id);
    			else
    				$tempRequest = new TempRequestUser();

    			if($request->ajax()){
    				$tempData = [];
    				$tempData['user_id'] = $user_id;
    				$tempData['first_name'] = isset($request->first_name) ? $request->first_name : '';
    				$tempData['last_name'] = isset($request->last_name) ? $request->last_name : '';
    				$tempData['email'] = isset($request->email) ? $request->email : '';
    				$tempData['aadhar_number'] = isset($request->aadhar_number) ? $request->aadhar_number : '';
    				$tempData['mobile_number'] = isset($request->mobile_number) ? $request->mobile_number : '';
    				$tempData['address'] = isset($request->address) ? $request->address : '';
    				$tempData['state_id'] = isset($request->state) ? $request->state : '';
    				$tempData['district_id'] = isset($request->district) ? $request->district : '';
    				
					if(!is_null($tempUser)){
	    				$tempRequest = TempRequestUser::find($tempUser->id);
	    				$saveInfo = $tempRequest->update($tempData);
					}else{
	    				$saveInfo = TempRequestUser::create($tempData);
					}

    				$data['success'] = true;
    				$data['message'] = 'Your request has been sent to admin. After check your document admin will approve your request.';
    			}
    		}else{
    			$data['message'] = 'Invalid User';
    		}

    	}else{
    		$data['message'] = 'Something went wrong, please try later';
    	}
    	return Response::json($data, 200);
    }


	
/*==================================================
	  UPDATE BANK DETAIL UNDER PROFILE 
==================================================*/  
	public function updateBankDetails(UpdateUserBankDetailsRequest $request,$user_id)
    {
		$data=array();
		 $result =array();
		//pr($request->all());	
		 $requestData = UserBankDetails::where('user_id',$user_id);
		 $stored_data = UserBankDetails::where('user_id',$user_id)->first();
		 
		if($request->ajax()){
			$data =array();
			$data['account_name']= $request->account_name;
			$data['bank_name']= $request->bank_name;
			$data['account_number'] = $request->account_number;
			$data['ifsc_code'] = $request->ifsc_code;
			$data['user_id'] = $user_id;
			
			if($stored_data){
				$requestData->update($data);
			}else{
				UserBankDetails::create($data);
			}
			
			
			//UPDATE PROFILE EVENT LOG END  
		   $result['success'] = true;
		   $result['account_name'] = $request->account_name;
		   $result['bank_name'] = $request->bank_name;
		   $result['account_number']= $request->account_number;
		   $result['ifsc_code']= $request->ifsc_code;
		   
		   return Response::json($result, 200);
		}
		
    }

/*==================================================
	  CHANGE PASSWORD 
==================================================*/ 
	public function passwordUpdate(UpdateUserPassword $request,$user_id)
    {
		// IF AJAX
		if($request->ajax()){
			$data=array();
			$userData = user_data();
			$userUpdate = User::where('id',$user_id);
			$newPassword=$request->password; //NEW PASSWORD
			$hashed = $userData->password;  //DB PASSWORD
	   
			if(Hash::check($request->old_password, $hashed)){
				$hashed = Hash::make($newPassword);
				
				$data['password'] = $hashed;			
				$userUpdate->update($data);
				$result =array(
				'success' => true
				);	
			}else{
				$result =array(
				'success' => false,
				'errors' => array('old_password'=>'Password does not match.')
				);	
			}
			return Response::json($result, 200);
		}
    }	
	

/*==================================================
	  sendEmailNotification
==================================================*/ 
	public function sendEmailNotification(sendEmailNotification $request,$user_id)
    {
		// IF AJAX
		if($request->ajax()){
			
			/* $user = user_data();
			$user_id = $user->id; 
			$user->qr_code = '<a href="'.url('customer-info').'/'.$user_id.'">Open Link</a>';
			$user->qr_code_link = url('customer-info').'/'.$user_id;
			return view('users.account.account', compact('user'));*/
			
			
			$uname = $request->owner_name;
			$logo = url('img/logo.png');
			$link= url('customer-info').'/'.$user_id;
			$to = $request->email;
			//EMAIL REGISTER EMAIL TEMPLATE 
			$result = EmailTemplate::where('template_name','email_notification')->first();
			$subject = $result->subject;
      		$message_body = $result->content;
      		
      		$list = Array
              ( 
                 '[LINK]' => $link,
                 '[LOGO]' => $logo,
              );

      		$find = array_keys($list);
      		$replace = array_values($list);
      		$message = str_ireplace($find, $replace, $message_body);
			
			//$mail = send_email($to, $subject, $message, $from, $fromname);
			
			$mail = send_email($to, $subject, $message);
			
			if($mail){
				
				$result =array(
					'success' => true
				);	
			}else{
				$result =array(
					'success' => false,
					'errors' => array('old_password'=>'Unable to send email.')
				);	
			}
			return Response::json($result, 200);
		}
    }	
	
/*==================================================
	   //ADVANCE FILTER SEARCH FOR USER 
==================================================*/
	public function advance_search($request,$user_id)
	{
			
		    // USER/ANALYST NOT ABLE TO ACCESS THIS 
		//	access_denied_user_analyst();
			$number_of_records =$this->per_page;
			$name = $request->name;
			$business_name = $request->business_name;
			$email = $request->email;
			$role_id = $request->role_id;
			
			//pr($request->all());
			//USER SEARCH START FROM HERE
			$result = User::where(`1`, '=', `1`);
		//	$result = User::where('id', '!=', user_id());
			$roleIdArr = Config::get('constant.role_id');
			
			
			if($business_name!='' || $name!='' || $email!=''|| trim($role_id)!=''){
				
				$user_name = '%' . $request->name . '%';
				$business_name = '%' . $request->business_name . '%';
				$email_q = '%' . $request->email .'%';
				
				
				
				// check email 
				if(isset($email) && !empty($email)){
					$result->where('email','LIKE',$email_q);
				} 
				// check name 
				if(isset($name) && !empty($name)){
					
					$result->where('owner_name','LIKE',$user_name);
				}
				if(isset($business_name) && !empty($business_name)){
					
					$result->where('business_name','LIKE',$business_name);
				}
				
				//If Role is selected 
				if(isset($role_id) && !empty($role_id)){
					$result->where('role_id',$role_id);
				}
			
				
				//	echo  $result->toSql();
				
			  // USER SEARCH END HERE   
			 }
			
			if($user_id){
				$result->where('created_by', '=', $user_id);
			}
			
				
			 $users = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
			
			return $users ;
	}
	
	// ENABLE/DISABLE 
	public function enableDisableUser(Request $request)
	{
		if($request->ajax()){
			$user = User::where('id',$request->user_id);

			$data =array();
			$data['status'] =  $request->status;
			$user->update($data);
			
			// Show message on the basis of status 
			if($request->status==1)
			 $enable =true ;
			if($request->status==0)
			 $enable =false ;
		  
		   $result =array('success' => $enable);	
		   return Response::json($result, 200);
		}
		
	}

	//VERIFY ACCOUNT  
	public function verifyAccount($token)
    {
		
		$result = User::where('verify_token', '=' ,$token)->get();
		$notwork =false; 
		if(count($result)>0){
			if($result[0]->created_by == 0){
				$userUpdate = User::where('email',$result[0]->email);
				$data['verify_token'] =NULL;			
				$data['status'] =1;		
				$data['created_by'] = 1;
				$userUpdate->update($data);
				return redirect('login')->with('success','Your account is verified.');	;
			}else{
				$url_post = url('password/reset_new_user_password');
				$notwork =true;  
				return view('auth.passwords.reset',compact('token','notwork','url_post'));	
			}
			/* $userUpdate = User::where('email',$result[0]->email);
			$data['verify_token'] =NULL;			
			$data['status'] =1;			
			$userUpdate->update($data); */
			
		}else{
			 return redirect('login')->with('error','Your Link is not correct to reset password.');	;
		}
		
		
        	
    }
	public function exportUsers(Request $request){
		
		$request->role_id = 2;
		$number_of_records =$this->per_page;
		$name = $request->name;
		$business_name = trim($request->business_name);
		$email = $request->email;
		$role_id = $request->role_id;
		
		$result = User::where(`1`, '=', `1`);
		
		$roleIdArr = Config::get('constant.role_id');
		
		if($business_name != '' && $name !='' || $email !=''|| trim($role_id) != ''){
			
			$user_name = '%' . $request->name . '%';
			$business_name_1 = '%'.$request->business_name.'%';
			$email_q = '%' . $request->email .'%';
			
			
			
			// check email 
			if(isset($email) && !empty($email)){
				$result->where('email','LIKE',$email_q);
			} 
			// check name 
			if(isset($name) && !empty($name)){
				
				$result->where('owner_name','LIKE',$user_name);
			}
			if(isset($business_name_1) && !empty($business_name_1)){
				
				$result->where('business_name','LIKE',$business_name_1);
			}
			
			//If Role is selected 
			if(isset($role_id) && !empty($role_id)){
				$result->where('role_id',$role_id);
			}
		}
		
		$users = $result->orderBy('created_at', 'desc')->get();
		if($users && count($users) > 0){
			$records = [];
			foreach ($users as $key => $user) {
				$records[$key]['sl_no'] = ++$key;
				$records[$key]['name'] = $user->owner_name;
				$records[$key]['business_name'] = $user->business_name;
				$records[$key]['email'] = $user->email;
				$records[$key]['phone'] = $user->mobile_number;
				$records[$key]['business_url'] = $user->business_url;
				$records[$key]['qr_code_link'] = url('customer-info').'/'.$user->id;
				$records[$key]['address'] =  $user->address;
				$records[$key]['registraion'] =  date('m/d/Y h:m A', strtotime($user->created_at));
			}
			$header = ['S.No.', 'Contact Name','Business Name', 'Email','Phone', 'Business URL', 'QR Code Link', 'Address', 'Registration Date/Time'];
		

			//load the CSV document from a string
			$csv = Writer::createFromString('');

			//insert the header
			$csv->insertOne($header);

			//insert all the records
			$csv->insertAll($records);
			@header("Last-Modified: " . @gmdate("D, d M Y H:i:s",$_GET['timestamp']) . " GMT");
			@header("Content-type: text/x-csv");
			// If the file is NOT requested via AJAX, force-download
			if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
				header("Content-Disposition: attachment; filename=search_results.csv");
			}
			//
			//Generate csv
			//
			echo $csv;
			exit();
		}else{
			$result =array('success' => false);	
		    return Response::json($result, 200);
		}
		
		
	}
	
    // LOGOUT 
	public function logout()
    {
      
		$logData = array();
		$user_id = user_id();
		$users = User::where('id',$user_id)->first();
		
		 Auth::logout();
		 return redirect('login');
		
		
    }
	
	public function delete_user($user_id){
		if($user_id){
			User::where('id',$user_id)->delete();
			$result =array('success' => true);	
			return Response::json($result, 200);
		}
	}
	
	function password_generate($chars) 
	{
	  $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
	  return substr(str_shuffle($data), 0, $chars);
	}
	
	
	
	/*----------------------- Document Upload *---------------------------------*/
	
	/*----------------------- Document Upload *---------------------------------*/
	
	

  
}
