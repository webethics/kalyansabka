<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Requests\sendEmailNotification;
use App\Http\Requests\ResetPassword;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\CdrGroup;
use App\Models\EmailTemplate;
use App\Models\TempRequestUser;
use App\Models\CityLists;
use App\Models\StateList;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;
//use Zip;

class RequestsController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function edit_request(){
		
		 return view('requests.edit_request');	
	}

	/*Request*/
	public function requests(Request $request)
    {
		access_denied_user('edit_request_listing');
		
        $requests_data = $this->requests_search($request,$pagination=true);
        $requests = $requests_data['requests'];
		$page_number =  $requests_data['current_page'];
		if(empty($page_number))
			$page_number = 1;
		//if($page_number > 1 )$page_number = $page_number - 1;else $page_number = $page_number;
		$statelist = StateList::all();
		$citylist = CityLists::all();
        if(!is_object($requests)) return $requests;
        if ($request->ajax()) {
            return view('requests.requestsPagination', compact('requests','page_number','statelist','citylist'));
        }
        return view('requests.requests',compact('requests','page_number','statelist','citylist'));	
	}
	
	public function requests_search($request,$pagination)
	{
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$mobile_number = $request->mobile_number;
		$aadhar_number = $request->aadhar_number;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$state_id = $request->state_id;
		$district_id = $request->district_id;

		//$result = TempRequestUser::where(`1`, '=', `1`);
		$result = TempRequestUser::where('status', 0);

		if($first_name!='' || $last_name!='' || $start_date!='' || $end_date!='' || $email!='' || $mobile_number != '' || $aadhar_number != ''|| $state_id != '' || $district_id != ''){
			
			if($start_date!= '' || $end_date!=''){

				//if end date empty
				if(empty($end_date))
					$end_date = date('Y-m-d');

				if((($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
					return  'date_error'; 
				}
			}
			
			if(!empty($start_date) &&  !empty($end_date)){
				$start_date_c = date('Y-m-d',strtotime($start_date));
				$end_date_c= date('Y-m-d',strtotime($end_date));

				$result->where(function($q) use ($start_date_c,$end_date_c) {
				$q->whereDate('created_at','>=' ,$start_date_c);
				$q->whereDate('created_at','<=', $end_date_c );
			  });
			} 
			
			// check email 
			if(isset($email) && !empty($email)){
				$email_q = '%' . $email .'%';
				$result->where('email','LIKE',$email_q);
			}
			
			// check name 
			if(isset($first_name) && !empty($first_name)){
				$first_name_s = '%' . $first_name . '%';
				$result->where('first_name','LIKE',$first_name_s);
			}
			if(isset($last_name) && !empty($last_name)){
				$last_name_s = '%' . $last_name . '%';
				$result->where('last_name','LIKE',$last_name_s);
			}
		 	if(isset($mobile_number) && !empty($mobile_number)){
		 		$mobile_number_s = '%' . $mobile_number . '%';
				$result->where('mobile_number','LIKE',$mobile_number_s);
			} 

			if(isset($aadhar_number) && !empty($aadhar_number)){
				$aadhar_number_s = '%' . $aadhar_number . '%';
				$result->where('aadhar_number','LIKE',$aadhar_number_s);
			}

			if(isset($state_id) && !empty($state_id)){
				$result->where('state_id',$state_id );
			} 

			if(isset($district_id) && !empty($district_id)){
				$result->where('district_id',$district_id );
			}
		}
		
		//$result->where('role_id', '!=', 1);
		$result->orderBy('created_at', 'desc')->toSql();
		
		if($pagination == true){
			$requests = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$requests = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['requests'] = $requests;
		$data['current_page'] = $page_number;

		//$requests = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $data;
	}

	/*Request View*/
	public function request_view($request_id)
    {
		access_denied_user('request_new_detail');

		$view = '';
		$success = false;

        $tempRequestUser = TempRequestUser::with('user')->where('id',$request_id)->first();
        
        if(!is_null($tempRequestUser) && ($tempRequestUser->count())>0){
        	$currentStateName = StateList::where('id',$tempRequestUser->user->state_id)->first();
        	$currentDistrictName = CityLists::where('id',$tempRequestUser->user->district_id)->first();
        	$requestStateName = StateList::where('id',$tempRequestUser->state_id)->first();
        	$requestDistrictName = CityLists::where('id',$tempRequestUser->district_id)->first();
        	$view = view("modal.viewDetail",compact('tempRequestUser','currentStateName','currentDistrictName','requestStateName','requestDistrictName'))->render();
        	$success = true;
        }
        //abort_unless(\Gate::allows('request_edit'), 403);
		
		return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }

    /*Update Request*/
    public function request_update($request_id,Request $request){
    	access_denied_user('request_new_detail');

    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';

    	if(!empty($request_id) && isset($request->status) && !empty($request->status)){
    		$status = 2;
    		if($request->status == 'approve'){
    			$status = 1;
    			$updateData = $this->updateUserInfo($request_id);
    		}

    		$tempRequestUser = TempRequestUser::find($request_id);
    		$updateTempRequest = $tempRequestUser->update(['status'=>$status]);
    		if($updateTempRequest == true){

    			$requests_data = $this->requests_search($request,$pagination=true);
		        $requests = $requests_data['requests'];
				$page_number =  $requests_data['current_page'];
				if(empty($page_number))
					$page_number = 1;
				//if($page_number > 1 )$page_number = $page_number - 1;else $page_number = $page_number;
		        if(!is_object($requests)) return $requests;
		        //$view = view('requests.requestsPagination', compact('requests','roles','page_number'));

    			/*$data['success'] = true;
    			$data['message'] = 'Successfully Update Edit Request';
    			$data['view'] = $view;*/
    			$statelist = StateList::all();
				$citylist = CityLists::all();
    			return view('requests.requestsPagination', compact('requests','page_number','statelist','citylist'));
    		}else{
    			//$data['message'] = 'Something went wrong, please try later';
    			return 'error';
    		}
    	}
    	//return Response::json($data, 200);
    }

    /*Download User document*/
    public function download_document($user_id){
    	/*$zip = new Zip;
    	$file_name = 'FullPlan.pdf';
		$file_path = public_path().'/uploads/certificates';
		$fileName = 'myNewFile.zip';
		$zip_name = $file_path.'/'.$fileName;
    	$zip = Zip::create($zip_name);
    	

    	if ($zip === TRUE){
    		$zip->add( array($file_path.'/'.$file_name));
    		$zip->close();
    	}
    	return response()->download(public_path($zip_name));*/

    }

    /*Update User Data*/
    public function updateUserInfo($request_id){
    	$tempRequestUser = TempRequestUser::where('id',$request_id)->first();
    	if(!is_null($tempRequestUser) && ($tempRequestUser->count())>0){
    		$user = User::find($tempRequestUser->user_id);

    		$tempData = [];
			$tempData['first_name'] = isset($tempRequestUser->first_name) ? $tempRequestUser->first_name : '';
			$tempData['last_name'] = isset($tempRequestUser->last_name) ? $tempRequestUser->last_name : '';
			$tempData['email'] = isset($tempRequestUser->email) ? $tempRequestUser->email : '';
			$tempData['aadhar_number'] = isset($tempRequestUser->aadhar_number) ? $tempRequestUser->aadhar_number : '';
			$tempData['mobile_number'] = isset($tempRequestUser->mobile_number) ? $tempRequestUser->mobile_number : '';
			$tempData['address'] = isset($tempRequestUser->address) ? $tempRequestUser->address : '';
			$tempData['state_id'] = isset($tempRequestUser->state_id) ? $tempRequestUser->state_id : '';
			$tempData['district_id'] = isset($tempRequestUser->district_id) ? $tempRequestUser->district_id : '';

			$saveInfo = $user->update($tempData);
    	}
    	return true;
    }
	
	
}
?>