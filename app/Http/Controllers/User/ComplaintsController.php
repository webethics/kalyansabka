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
		
		$result = Complaints::where(`1`, '=', `1`)->with('user');
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
			return Response::json(array(
			  'success'=>true,
			 ), 200);
		}
	}
	public function complaint_delete($complaint_id)
    {
		
		if($complaint_id){
			$main_complaint = Complaints::where('id',$complaint_id)->first();
			if($main_complaint){
				
				Complaints::where('id',$complaint_id)->delete();
				$result =array('success' => true);	
				return Response::json($result, 200);
			}else{
				$result =array('success' => false,'message'=>'There is no complaint found .');	
				return Response::json($result, 200);
			}
			
		}
	}
}
?>