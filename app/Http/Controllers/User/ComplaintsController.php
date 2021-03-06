<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateComplaintRequest;
use App\Http\Requests\UpdateComplaintRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

use App\Models\EmailTemplate;
use App\Models\Complaints;
use App\Models\Reply;
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
use Session;
use DateTime;
use Carbon\Carbon;
use ZipArchive;

class ComplaintsController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function complaints(Request $request){
		/*check if admin user login and manage user with another tab, then login user by Id*/
    	if(!empty(Session::get('is_admin_login'))  && Session::get('is_admin_login') == 1 && !empty(Session::get('user_id'))){
    		Auth::loginUsingId(Session::get('user_id'));
    	}
		$user_id = Auth::id();
		$request->user_id = $user_id;
		$complaints_data = $this->complaints_search($request,$pagination=true);
		if($complaints_data['success']){
			$complaints = $complaints_data['complaints'];
			//echo '<pre>';print_r($complaints->toArray());die;
			$page_number =  $complaints_data['current_page'];
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($complaints)) return $complaints;
			if ($request->ajax()) {
				return view('complaints.complaintsPagination', compact('complaints','page_number'));
			}
			return view('complaints.complaints',compact('complaints','page_number'));	
		}else{
			return $complaints_data['message'];
		} 
		return view('complaints.complaints',compact('complaints','page_number'));	
		
	}
	public function list_complaints(Request $request){
		access_denied_user('complaints_listing');
       $complaints_data = $this->complaints_search($request,$pagination=true);
		if($complaints_data['success']){
			$complaints = $complaints_data['complaints'];
			
			$page_number =  $complaints_data['current_page'];
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($complaints)) return $complaints;
			if ($request->ajax()) {
				return view('complaints.listComplaintsPagination', compact('complaints','page_number'));
			}
			return view('complaints.listComplaints',compact('complaints','page_number'));	
		}else{
			return $complaints_data['message'];
		} 
		return view('complaints.complaints',compact('complaints','page_number'));	
		
	}
	public function complaints_search($request,$pagination)
	{
		
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$user_id = $request->user_id;
		
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		
		$mobile = $request->mobile_number;
		$aadhaar = $request->aadhar_number;
		$status = $request->status;
		
		
		
		$result = Complaints::where(`1`, '=', `1`)->with('user');
		
		if($first_name!='' || $last_name!='' || $email!='' || $mobile!='' || $aadhaar!='' || $status !=''){
			
			$email_q = '%' . $request->email .'%';
			// check email 
			if(isset($email) && !empty($email)){
			
				$result->whereHas('user', function (Builder $query) use ($email_q) {
					$query->where('email','LIKE',$email_q);
				});
			} 
			
			$first_name_s = '%' . $first_name . '%';
			$last_name_s = '%' . $last_name . '%';
			
			// check name 
			if(isset($first_name) && !empty($first_name)){
				$result->whereHas('user', function (Builder $query) use ($first_name_s) {
					$query->where('first_name','LIKE',$first_name_s);
				});
			}
			if(isset($last_name) && !empty($last_name)){
				$result->whereHas('user', function (Builder $query) use ($last_name_s) {
					$query->where('last_name','LIKE',$last_name_s);
				});
			}
		 	if(isset($mobile) && !empty($mobile)){
				$result->whereHas('user', function (Builder $query) use ($mobile)  {
					$query->where('mobile_number','=',$mobile);
				});
			}
		 	if(isset($aadhaar) && !empty($aadhaar)){
				$result->whereHas('user', function (Builder $query) use ($aadhaar) {
					$query->where('aadhar_number','LIKE',$aadhaar);
				});
			}
		 	if($status != ''){
				$result->where('status',$status);
			}
		}
		
		
		if($user_id && $user_id != ''){
			$result->where('user_id',$user_id);
		}
		
		
		
		
		if($pagination == true){
			$complaints = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$complaints = $result->orderBy('created_at', 'desc')->get();
		}
		
		//print_r($complaints->toArray());die;
		
		$data = array();
		$data['success'] = true;
		$data['complaints'] = $complaints;
		$data['current_page'] = $page_number;
		return $data; 
	}
	public function complaint_create()
    {
		
		$view = view("modal.complaintCreate")->render();
		$success = true;

        return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	
	public function update_complaint(UpdateComplaintRequest $request,$complaint_id){
		$data=array();
		$result =array();
		$requestData = Complaints::where('id',$complaint_id);
		$stored_data = Complaints::where('id',$complaint_id)->first();
		
		if($request->ajax()){
			$data =array();
			
			$data['subject']	= $request->subject;
			$data['message'] 	= $request->message; 
			
			$requestData->update($data);
			if($request->reply){
				$reply_data['user_id'] = Auth::id();
				$reply_data['complaint_id'] = $complaint_id;
				$reply_data['reply'] = $request->reply;
				Reply::create($reply_data);
			}
			$result['success'] = true;
			//UPDATE PROFILE EVENT LOG END  
			
			$result['subject'] = $request->subject;
			
			return Response::json($result, 200);
		}
	}
	
	public function update_complaint_admin(UpdateComplaintRequest $request,$complaint_id){
		$data=array();
		$result =array();
		$requestData = Complaints::where('id',$complaint_id);
		$stored_data = Complaints::where('id',$complaint_id)->first();
		
		if($request->ajax()){
			$data =array();
			
			$data['subject']	= $request->subject;
			$data['message'] 	= $request->message; 
			$data['status'] 	= $request->status; 
			
			if ($request->status == "0") $status = 'New';
			if ($request->status == "1")  $status =  'In Progress';
			if ($request->status == "2")  $status = 'Completed';
					
			$requestData->update($data);
			if($request->reply){
				$reply_data['user_id'] = Auth::id();
				$reply_data['complaint_id'] = $complaint_id;
				$reply_data['reply'] = $request->reply;
				Reply::create($reply_data);
			}
			
			$result['success'] = true;
			//UPDATE PROFILE EVENT LOG END  
			
			$result['subject'] = $request->subject;
			
			$result['status'] = $status;
			
			return Response::json($result, 200);
		}
	}
	
	public function complaint_edit($complaint_id)
    {
		
        $complaint = Complaints::where('id',$complaint_id)->with('replies')->get();
		
		if(count($complaint)>0){
			$complaint =$complaint[0];
			$getreplies = Reply::where('complaint_id',$complaint_id)->with('user')->get();
			$view = view("modal.complaintEdit",compact('complaint','getreplies'))->render();
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
	public function list_complaint_edit($complaint_id)
    {
		access_denied_user('complaints_edit');
        $complaint = Complaints::where('id',$complaint_id)->get();
		if(count($complaint)>0){
			$complaint =$complaint[0];
			$getreplies = Reply::where('complaint_id',$complaint_id)->with('user')->get();
			$view = view("modal.listComplaintEdit",compact('complaint','getreplies'))->render();
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
	
	public function complaint_create_new(CreateComplaintRequest $request){
		$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
		if($request->ajax()){
			$user_id = Auth::id();
			$data =array();
			$data['subject']	= $request->subject;
			$data['user_id']	= $user_id;
			$data['message'] 	= $request->message; 
			$data['ticket_id']	= getToken(9); 
			$data['status']		= 0; 
			//print_r($data);die;
			$dat = Complaints::create($data);

			/*fetch all complaint*/
			$user_id = Auth::id();
			$request->user_id = $user_id;
			$complaints_data = $this->complaints_search($request,$pagination=true);
			$complaints = [];
			$page_number = 1;
			if($complaints_data['success']){
				$complaints = $complaints_data['complaints'];
				//echo '<pre>';print_r($complaints->toArray());die;
				$page_number =  $complaints_data['current_page'];
				if(empty($page_number))
					$page_number = 1;
			}

			$data['success'] = true;
			$data['message'] = 'New complaint successfully send to admin';
			$data['view'] = view("complaints.complaintsPagination",compact('complaints','page_number'))->render();
		}
		return Response::json($data, 200);
	}
	public function complaint_delete(Request $request,$complaint_id)
    {
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
    	$user_id = Auth::id();
    	$isAdminLogin = 1; /*flag that check is admin user login or not*/
    	/*check complaint is done by same user who is login,then give him access to delete complaint*/
    	$isComplaintUser = Complaints::where('user_id',$user_id)->where('id',$complaint_id)->exists();
    	if($isComplaintUser){
    		//go ahead
    		$request->user_id = $user_id;
    		$isAdminLogin = 0;
    	}else{
    		access_denied_user('complaints_delete');
    		$isAdminLogin = 1;
    	}
		
		if($complaint_id){
			$main_complaint = Complaints::where('id',$complaint_id)->first();
			if($main_complaint){
				
				Complaints::where('id',$complaint_id)->delete();

				$complaints_data = $this->complaints_search($request,$pagination=true);
				$complaints = [];
				$page_number = 1;
				if($complaints_data['success']){
					$complaints = $complaints_data['complaints'];
					//echo '<pre>';print_r($complaints->toArray());die;
					$page_number =  $complaints_data['current_page'];
					if(empty($page_number))
						$page_number = 1;
				}

				$data['success'] = true;
				$data['message'] = 'Successfully Delete complaint.';
				if($isAdminLogin)
					$data['view'] = view("complaints.listComplaintsPagination",compact('complaints','page_number'))->render();
				else
					$data['view'] = view("complaints.complaintsPagination",compact('complaints','page_number'))->render();
			}else{
				$data['message'] = 'There is no complaint found.';
			}
			
		}
		return Response::json($data, 200);
	}
}
?>