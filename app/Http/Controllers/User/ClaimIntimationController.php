<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Requests\sendEmailNotification;
use App\Http\Requests\ResetPassword;
use App\Http\Requests\UpdateWithdawalRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\ClaimIntimation;
use App\Models\UserPayment;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class ClaimIntimationController extends Controller
{
	
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
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