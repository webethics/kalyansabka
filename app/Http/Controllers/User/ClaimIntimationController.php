<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClaimIntimation;
use App\Models\ClaimMedia;
use App\Http\Requests\CreateClaimRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\UserPayment;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use File;
use Crypt;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ClaimIntimationController extends Controller
{
	
	protected $per_page;
	private $claim_document_path;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
        $this->claim_document_path = public_path('/uploads/claim/');
    }

    /*This function execute in frontend*/
    public function frontClaimForm(){
    	return view('users.users.claimIntimation');
    }

    /*
	* LOGO UPLOAD ON AJAX REQUEST
	*/
	public function uploadLogo(Request $request, $user_id){
		$requestData = Setting::where('id',1);
		if($request->ajax()){
			$data =array();
			$logo = $request->file('file');
			if (!is_dir($this->photos_path)) {
				mkdir($this->photos_path, 0777);
			}
			$settings =  Setting::where('id',1)->get()[0];
			if(!empty($settings->site_logo)){
				$file_path = $this->photos_path.$settings->site_logo;
				File::delete($file_path);
			}
			$randomString = sha1(date('YmdHis') . Str::random(30));
			$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
			$data['site_logo'] = $save_name;
			$requestData->update($data);
			$logo->move($this->photos_path, $save_name);
			$result =array(
				'success' => true,
				'filePath' => $this->photos_path,
				'name'=>$save_name
			);	
			return Response::json($result, 200);
			
		}
	}

	/*
	* LOGO UPLOAD ON AJAX REQUEST
	*/
	public function uploadClaimDocument(Request $request){
		if($request->ajax()){
			$data =array();
			
			if (!is_dir($this->claim_document_path)) {
				mkdir($this->claim_document_path, 0777,true);
			}
			//$documents =  UserDocuments::where('user_id',$user_id)->first();
			$documents = $request->file('file1');
			$mediaIds = []; $mediaNames = [];
			if(count($documents) >0){
				foreach ($documents as $key => $doc) {
					$randomString = sha1(date('YmdHis') . Str::random(30));
					$original_name = $doc->getClientOriginalName();
					$new_name = $randomString . '.' . $doc->getClientOriginalExtension();
					$upload_type = $doc->getMimeType();
					
					$doc->move($this->claim_document_path, $new_name);

					//STORE MEDIA 
	                $claimMedia = new ClaimMedia;
	                $claimMedia->original_name = $original_name;
	                $claimMedia->media=$new_name;
	                $claimMedia->upload_type=$new_name;
	                $claimMedia->save();

	                array_push($mediaIds,$claimMedia->id);
	                array_push($mediaNames,$original_name);
	            }
			}
			/*$randomString = sha1(date('YmdHis') . Str::random(30));
			$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
			$data['document_name'] = $save_name;*/
			$message  = "Document image successfully uploaded.";
			
			$result =array(
				'success' => true,
				'filePath' => $this->claim_document_path,
				'medias'=>$mediaIds,
				'names'=>$mediaNames,
				'message'=>$message
			);	
			return Response::json($result, 200);
		}
	}
	/*
	* DELETING claim document AJAX REQUEST
	*/
	public function deleteClaimDocument(Request $request, $claim_id){
		$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
		if($request->ajax()){
			$rqst_file_name = $request->file_name;
			
			$requestData = ClaimMedia::find($claim_id);
			$documents =  ClaimMedia::where('id',$claim_id)->first();
			if($requestData){
				$file_path = $this->claim_document_path.$documents->media;
				$db_file_name = $documents->original_name;
				if($db_file_name == $rqst_file_name){
					File::delete($file_path);
					$requestData->delete();

					$data['success'] = true;
    				$data['message'] = 'Document delete Successfully.';
				}
			}
		}
		return Response::json($data, 200);
	}



    /*Save claim function*/
    public function createClaimForm(CreateClaimRequest $request){
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';

    	//dd($request->all());
    	$request_data = $request->all();
    	$isValidIntemuser = false;
    	$intemateUserPolicyNumber = '';
    	$intemateAadharNumber = '';

    	/*Check if valid policy id or valid initimate aadhar number*/
    	if(isset($request_data['policy_number']) && !empty($request_data['policy_number'])){
    		$intemateUserPolicyNumber = trim($request_data['policy_number']);
    	}
    	if(isset($request_data['initimation_aadhar_number']) && !empty($request_data['initimation_aadhar_number'])){
    		$intemateAadharNumber = trim($request_data['initimation_aadhar_number']);
    		$intemateAadharNumber = str_replace("-","",$intemateAadharNumber);
    	}

    	$user = User::with('userNominee');
    	/*Check valid User*/
    	if(!empty($intemateUserPolicyNumber)){
    		$user = $user->where('policy_number',$intemateUserPolicyNumber);
    	}elseif(!empty($intemateAadharNumber)){
    		$user = $user->where('aadhar_number',$intemateAadharNumber);
    	}
    	$user = $user->where('mobile_number',$request_data['initimation_mobile_number'])->first();

    	if(!is_null($user) && ($user->count())>0){
			/*Valid intemate user, now check valid nominee name*/
			$nominee_number = intval($user->nominee_number);
			if($nominee_number>0){
				if(!is_null($user->userNominee) && ($user->userNominee->count())>0){
					$userNominee = $user->userNominee;
					$isNomineeFound = 0;
					foreach ($userNominee as $key => $nominee) {
						if(strtolower(trim($nominee['name'])) == strtolower(trim($request_data['name']))){
							$isNomineeFound = 1;
							break;
						}
					}
					/*if nominee found with same name*/
					if($isNomineeFound){
						//save data in claim intermate
						$generated_claim_id = getToken(9);
			            $claimData = ClaimIntimation::create([
			                'claim_request_id' => $generated_claim_id,
			                'policy_number' => trim($request_data['policy_number']),
			                'initimation_aadhar_number' => $intemateAadharNumber,
			                'initimation_mobile_number' => trim($request_data['initimation_mobile_number']),
			                'name' => trim($request_data['name']),
			                'aadhar_number' => str_replace("-","",(trim($request_data['aadhar_number']))),
			                'mobile_number' => trim($request_data['mobile_number'])
			            ]);

			            /*if document not empty*/
			            if(!empty($request_data['document'])){
			            	$documentIds = explode(",",$request_data['document']);
			            	/*check if not empty documents ids and not empty claim id then update docoments medias claim ids*/
			            	if(count($documentIds) > 0 && intval($claimData->id) > 0){
				            	foreach ($documentIds as $key => $doc) {
				            		$claimMedia = ClaimMedia::find($doc);

							        if ($claimMedia) {
							            $claimMedia->update([
							                'claim_intimation_id' => $claimData->id
							            ]);
							        }
				            	}
				            }
			            }
			            $view = view("users.users.claimRequestToken",compact('claimData'))->render();
			            $data['success'] = true;
    					$data['message'] = 'Your claim request is successfully send to admin';
    					$data['view'] = $view;
						
					}else{
						$data['message'] = 'Nominee name not match with our records';
					}
				}
			}else{
				$data['message'] = 'No nominee account exist with intemate '.$user->full_name;
			}
		}else{
			$data['message'] = 'Invalid Intemate person Details';
		}	
		return Response::json($data, 200);

    }



	public function intimations(Request $request)
    {
		access_denied_user('claim_intimation_listing');
		$intimations_data = $this->intimations_data_search($request,$pagination=true);
		
		if($intimations_data['success']){
			$intimations = $intimations_data['intimations'];
			$page_number =  $intimations_data['current_page'];
			
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($intimations)) return $intimations;
			if ($request->ajax()) {
				return view('intimations.intimationsPagination', compact('intimations','page_number','roles'));
			}
			return view('intimations.intimations',compact('intimations','page_number','roles'));	
		}else{
			return $intimations_data['message'];
		}
		
	}
	public function intimations_data_search($request,$pagination)
	{
		$page_number = $request->page;
		
		$number_of_records =$this->per_page;
		
		$result = ClaimIntimation::where(`1`, '=', `1`);	
		
		if($pagination == true){
			$intimations = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$intimations = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['success'] = true;
		$data['intimations'] = $intimations;
		$data['current_page'] = $page_number;
		return $data;
		
	}
	
	public function request_edit($request_id)
    {
		
		//access_denied_user('payment_edit');
        $request = ClaimIntimation::where('id',$request_id)->with('user')->first();
		
	//	echo '<pre>';print_r($request->toArray());die;
		$user_id = $request->user_id;
		
		
		if($request){
			
			$view = view("modal.claimRequestEdit",compact('request'))->render();
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
	public function request_update($request_id,Request $request){
		access_denied_user('claim_intimation_edit');
		$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
		
    	if(!empty($request_id) && isset($request->status) && !empty($request->status)){
			//$getpolicydata = CancelPolicyRequest::where('id',$request_id);
			$getclaimdata = ClaimIntimation::find($request_id);
    		if($request->status == 'approve'){
				$status = 1;
    			$request_data['status'] = 2;
    			$updateData =$getclaimdata->update($request_data);
    		}
			if($request->status == 'disapprove'){
				$request_data['status'] = 1;
				$request_data['description'] = trim($request->description);	
				$updateData =$getclaimdata->update($request_data);
			}
			return Response::json(array(
					  'success'=>true,
					), 200);
		}else{
    		return 'error';
    	}
    	//return Response::json($data, 200);
    }
}