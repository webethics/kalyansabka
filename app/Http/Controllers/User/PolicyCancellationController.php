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
use App\Models\WithdrawlRequest;
use App\Models\CancelPolicyRequest;
use App\Models\IncomeHistory;
use App\Models\Income;
use App\Models\EmailTemplate;
use App\Models\UserBankDetails;
use App\Models\WithdrawalRequestCharges;
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

class PolicyCancellationController extends Controller
{
	
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	public function policyCancellations(Request $request)
    {
		
		access_denied_user('policy_cancellation_listing');
		$policyCancellations_data = $this->cancelled_policy_search($request,$pagination=true);
		
		if($policyCancellations_data['success']){
			$cancelledPolicyRequests = $policyCancellations_data['cancelled_policies'];
			$page_number =  $policyCancellations_data['current_page'];
			
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($cancelledPolicyRequests)) return $cancelledPolicyRequests;
			if ($request->ajax()) {
				return view('policyCancellations.cancelledRequestsPagination', compact('cancelledPolicyRequests','page_number','roles'));
			}
			return view('policyCancellations.cancelled_requests',compact('cancelledPolicyRequests','page_number','roles'));	
		}else{
			return $policyCancellations_data['message'];
		}
		
	}
	public function cancelled_policy_search($request,$pagination)
	{
		$page_number = $request->page;
		
		$number_of_records =$this->per_page;
		
		$result = CancelPolicyRequest::where(`1`, '=', `1`)->with('user');	
		
		if($pagination == true){
			$cancelled_policies = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$cancelled_policies = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['success'] = true;
		$data['cancelled_policies'] = $cancelled_policies;
		$data['current_page'] = $page_number;
		return $data;
		
	}
	
	public function request_edit($request_id)
    {
		
		access_denied_user('policy_cancellation_edit');
        $request = CancelPolicyRequest::where('id',$request_id)->with('user')->first();
		//echo '<pre>';print_r($request);die;
		$user_id = $request->user_id;
		
		if($request){
			$view = view("modal.policyRequestEdit",compact('request'))->render();
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
	
	/*Update Request*/
    public function request_update($request_id,Request $request){
    	access_denied_user('policy_cancellation_edit');
		$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
		
    	if(!empty($request_id) && isset($request->status) && !empty($request->status)){
			//$getpolicydata = CancelPolicyRequest::where('id',$request_id);
			$getpolicydata = CancelPolicyRequest::find($request_id);
    		if($request->status == 'approve'){
				$status = 1;
    			$request_data['request_status'] = 2;
    			$updateData =$getpolicydata->update($request_data);
    		}
			if($request->status == 'disapprove'){
				$request_data['request_status'] = 1;
				$request_data['description'] = trim($request->description);	
				$updateData =$getpolicydata->update($request_data);
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