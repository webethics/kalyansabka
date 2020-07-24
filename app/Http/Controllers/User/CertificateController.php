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
use App\Models\StateList;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class CertificateController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function certificates(Request $request)
    {
		
		$request->role_id = 1;
        $certificates_data = $this->certificate_search($request,$pagination=true);
        $certificates = $certificates_data['certificates'];
		$page_number =  $certificates_data['current_page'];
		if($page_number > 1 )$page_number = $page_number - 1;else $page_number = $page_number;
        //$roles = Role::all();
		$statelist = StateList::all();
		$citylist = CityLists::all();
        if(!is_object($certificates)) return $certificates;
        if ($request->ajax()) {
            return view('certificates.certificatesPagination', compact('certificates','statelist','citylist','page_number'));
        }
        return view('certificates.certificates',compact('certificates','roles','statelist','citylist','page_number'));	
	}
	
	public function certificate_search($request,$pagination)
	{
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$state_id = $request->state_id;
		$district_id = $request->district_id;
		$start_date = $request->start_date;
		$end_date = $request->end_date;

		//$result = User::where(`1`, '=', `1`);
		$result = User::where('hard_copy_certificate', '=', 'yes');
			
		if($first_name!='' || $last_name!='' || $start_date!='' || $end_date!='' || $email!='' || $state_id != '' || $district_id != ''){
			
			if($start_date!= '' || $end_date!=''){
				if((($start_date!= '' && $end_date=='') || ($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
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
		 	if(isset($state_id) && !empty($state_id)){
				$result->where('state_id',$state_id );
			} 

			if(isset($district_id) && !empty($district_id)){
				$result->where('district_id',$district_id );
			}
		}
		
		$result->where('role_id', '!=', 1);
		$result->orderBy('created_at', 'desc')->toSql();
		
		if($pagination == true){
			$certificates = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$certificates = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['certificates'] = $certificates;
		$data['current_page'] = $page_number;

		//$certificates = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $data;
	}
	
	public function customer_certificate(){
		
		return view('certificates.customer_certificate');	
	}
	
	public function certificate_request_edit($user_id)
    {
        $user = User::where('id',$user_id)->get();
		$roles = Role::all();
		if(count($user)>0){
			$user =$user[0];
			$view = view("modal.certificateEdit",compact('user','roles'))->render();
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

    /*Update Certificate*/
    public function update_certificate($user_id,Request $request){
    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
    	if(!empty($user_id) && isset($request->certificate_status)){
    		$sno = isset($request->sno) ? $request->sno : 1;
    		$page_number = isset($request->page_number) ? $request->page_number : 0;
    		$certificate = User::find($user_id);
    		$updateCertf = $certificate->update(['certificate_status'=>$request->certificate_status]);
    		if($updateCertf == true){
    			$data['success'] = true;
    			$data['message'] = 'Successfully Update Certificate Status';
    			$data['view'] = view("certificates.certificateSingleRow",compact('certificate','sno','page_number'))->render();
    			$data['class'] = 'user_row_'.$certificate->id;
    		}else{
    			$data['message'] = 'Something went wrong, please try later';
    		}
    	}
    	return Response::json($data, 200);
    	
    }
}
?>