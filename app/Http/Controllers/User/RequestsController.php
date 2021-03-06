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
use Illuminate\Database\Eloquent\Builder;
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;
use ZipArchive;

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
		$gender = $request->gender;

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

			if(isset($gender) && !empty($gender)){
				$result->whereHas('user', function (Builder $query) use ($gender) {
				    $query->where('gender', 'like', $gender);
				});
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

	/*Export request*/
	public function export_request(Request $request){
		$requests_data = $this->requests_search($request,$pagination=false);
        $requests = $requests_data['requests'];
		
		if($requests && count($requests) > 0){
			$records = [];
			foreach ($requests as $key => $request) {
				$status_text = 'Pending';
				if($request->status == 1)
					$status_text = 'Approve';
				elseif ($request->status == 2)
					$status_text = 'Disapprove';

				$records[$key]['sl_no'] = ++$key;
				$records[$key]['name'] = $request->full_name;
				$records[$key]['email'] = $request->email;
				$records[$key]['phone'] = $request->mobile_number;
				$records[$key]['address'] =  $request->address;
				$records[$key]['created'] =  date('d-m-Y h:i:s', strtotime($request->created_at));
				$records[$key]['status'] =  $status_text;
			}
			$header = ['S.No.', 'Name', 'Email','Mobile', 'Address', 'Created Date/Time','Status'];
		

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

	/*Request View*/
	public function request_view($request_id)
    {
		access_denied_user('request_new_detail');

		$view = '';
		$success = false;

        $tempRequestUser = TempRequestUser::with('user')->where('id',$request_id)->first();
        
        if(!is_null($tempRequestUser) && ($tempRequestUser->count())>0){
        	$currentStateName = '';
        	$currentDistrictName ='';
        	if(!is_null($tempRequestUser->user) && ($tempRequestUser->user->count())>0){
	        	$currentStateName = StateList::where('id',$tempRequestUser->user->state_id)->first();
	        	$currentDistrictName = CityLists::where('id',$tempRequestUser->user->district_id)->first();
	        }
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
    		$data =array();
			$data['status'] =$status;
			//if disapprove request then get description
			if($status == 2)
				$data['description'] = trim($request->description);

    		$updateTempRequest = $tempRequestUser->update($data);
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
    	}else{
    		return 'error';
    	}
    	//return Response::json($data, 200);
    }

    /*Check if user document exit*/
    public function document_exist($user_id){
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';

 		if(!empty($user_id)){
 			//Check Valid User
    		$user = User::with('userDocument')->where('id',$user_id)->first();

    		if(!is_null($user) && ($user->count())>0 && !is_null($user->userDocument) && ($user->userDocument->count())){
    			$udocument = $user->userDocument;
				$aadhaar_front = $udocument->aadhaar_front;
				$aadhaar_back = $udocument->aadhaar_back;
				$pan_card = $udocument->pan_card;

				//check if document exist
				if(!empty($aadhaar_front) || !empty($aadhaar_back) || !empty($pan_card)){
					$data['success'] = true;
    				$data['message'] = 'Document exist';
				}else{
					$data['message'] = 'No document Uploaded by User Yet.';
				}
    		}else{
				$data['message'] = 'No document Uploaded by User Yet.';
			}
 		}
 		
    	return Response::json($data, 200);
    }

    /*Download User document*/
    public function download_document($user_id){
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
    	//Check Valid User
    	$user = User::with('userDocument')->where('id',$user_id)->first();
    	
    	// Define Dir Folder
    	$public_dir=public_path();

		if(!is_null($user) && ($user->count())>0){
			// Zip File Name
        	$zipFileName = $user->full_name.'.zip';
        	$zipFileName = str_replace(" ","_",$zipFileName);
        	$directoryPath = public_path().'/uploads/documents/';
			//echo $user->bankDetails->count();
			if(!is_null($user->userDocument) && ($user->userDocument->count())>0){

				$udocument = $user->userDocument;
				$aadhaar_front = $udocument->aadhaar_front;
				$aadhaar_back = $udocument->aadhaar_back;
				$pan_card = $udocument->pan_card;

				$files = [];
				$files['aadhaar_front'] = $aadhaar_front;
				$files['aadhaar_back'] = $aadhaar_back;
				$files['pan_card'] = $pan_card;
				//array_push($files,$aadhaar_front,$aadhaar_back,$pan_card);

				//check if document exist
				if(!empty($aadhaar_front) || !empty($aadhaar_back) || !empty($pan_card)){
					if(!empty($aadhaar_front))
					// Create ZipArchive Obj
        			$zip = new ZipArchive;
        			$zipFullPathName = $directoryPath.$zipFileName;

        			if ($zip->open($zipFullPathName, ZipArchive::CREATE) === TRUE) {
        				//add the files
					    foreach($files as $key=>$file) {
					    	if(!empty($file) && file_exists($directoryPath.$file)){
					    		//explode file and get extension
					    		$file_name = explode('.',$file);
					    		$extension = end($file_name);
					    		//full file path
					    		$fullFilePath = $directoryPath.$file;
					    		//new created file name in zip folder
					    		$newFileName = $key.'.'.$extension;
								$zip->addFile($fullFilePath,$user->full_name.'/'.$newFileName);
					    	}
					    }
					    // Close ZipArchive     
            			$zip->close();
            			// Set Header
				        $headers = array(
				            'Content-Type' => 'application/octet-stream',
				        );
				        //$filetopath=$zip_path.'/'.$zipFileName;
				        // Create Download Response
				        if(file_exists($zipFullPathName)){
				            return response()->download($zipFullPathName,$zipFileName,$headers)->deleteFileAfterSend(true);
				            /*$data['fileurl'] = $zipFullPathName;
				            $data['success'] = true;
    						$data['message'] = 'Successfully downlad file';*/

				        }
				        $data['message'] = 'File does not exist';
        			}else{
        				$data['message'] = 'Something went wrong';
        			}

				}else{
					$data['message'] = 'No document Uploaded by User Yet.';
				}
			}else{
				$data['message'] = 'No document Uploaded by User Yet.';
			}
		}
    	return Response::json($data, 200);
    	//return "NO FILES CREATED";
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