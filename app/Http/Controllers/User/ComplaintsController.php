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
use App\Models\Company;
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
		
       $complaints_data = $this->complaints_search($request,$pagination=true);
		if($complaints_data['success']){
			$complaints = $complaints_data['complaints'];
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
		
		$result = Company::where(`1`, '=', `1`);
		if($pagination == true){
			$complaints = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$complaints = $result->orderBy('created_at', 'desc')->get();
		}
		
		
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
	public function complaint_edit($company_id)
    {
		
        $company = Company::where('id',$company_id)->get();
		if(count($company)>0){
			$company =$company[0];
			$view = view("modal.complaintEdit",compact('company'))->render();
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
	public function list_complaint_edit($company_id)
    {
		
        $company = Company::where('id',$company_id)->get();
		if(count($company)>0){
			$company =$company[0];
			$view = view("modal.listComplaintEdit",compact('company'))->render();
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
}
?>