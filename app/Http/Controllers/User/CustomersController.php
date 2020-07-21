<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\UpdateUserPassword;
use App\Http\Requests\sendEmailNotification;
use App\Http\Requests\ResetPassword;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\CdrGroup;
use App\Models\EmailTemplate;

use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class CustomersController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function customers(Request $request)
    {
		access_denied_user('customer_listing');
		
        $customers_data = $this->customer_search($request);
		$customers = $customers_data['customers'];
		$page_number =  $customers_data['current_page'];
		if($page_number > 1 )$page_number = $page_number - 1;else $page_number = $page_number;
		$roles = Role::all();
        if(!is_object($customers)) return $customers;
        if ($request->ajax()) {
            return view('customers.customersPagination', compact('customers','page_number','roles'));
        }
        return view('customers.customers',compact('customers','page_number','roles'));	
	}
	
	public function customer_search($request)
	{
		
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$role_id = $request->role_id;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
			
		
		$result = User::where(`1`, '=', `1`);
			
		if($first_name!='' || $last_name!='' || $role_id!='' || $start_date!='' || $end_date!='' || $email!=''){
			
			if($start_date!= '' || $end_date!=''){
				if((($start_date!= '' && $end_date=='') || ($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
					return  'date_error'; 
				}
			}
			
			$start_date_c = date('Y-m-d',strtotime($start_date));
			$end_date_c= date('Y-m-d',strtotime($end_date));
			
			if(!empty($start_date) &&  !empty($end_date)){
				$result->where(function($q) use ($start_date_c,$end_date_c) {
				$q->whereDate('created_at','>=' ,$start_date_c);
				$q->whereDate('created_at','<=', $end_date_c );
			  });
			} 
			
			$email_q = '%' . $request->email .'%';
			// check email 
			if(isset($email) && !empty($email)){
				$result->where('email','LIKE',$email_q);
			} 
			
			$first_name_s = '%' . $first_name . '%';
			$last_name_s = '%' . $last_name . '%';
			
			// check name 
			if(isset($first_name) && !empty($first_name)){
				$result->where('first_name','LIKE',$first_name_s);
			}
			if(isset($last_name) && !empty($last_name)){
				$result->where('last_name','LIKE',$last_name_s);
			}
		 	if(isset($role_id) && !empty($role_id)){
				$result->where('role_id',$role_id);
			} 
		}
		
		
		$result->where('role_id', '!=', 1);
		$result->orderBy('created_at', 'desc')->toSql();
				
		$customers = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		$data = array();
		$data['customers'] = $customers;
		$data['current_page'] = $page_number;
		return $data;
	}
	
	public function customer_edit($user_id)
    {
		access_denied_user('customer_edit');
        $user = User::where('id',$user_id)->get();
		$roles = Role::all();
		if(count($user)>0){
			$user =$user[0];
			$view = view("modal.customerEdit",compact('user','roles'))->render();
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
	public function customer_create_new(CreateCustomerRequest $request){
		if($request->ajax()){
			$data =array();
			$data['first_name']	= $request->first_name;
			$data['last_name'] = $request->last_name; 
			$data['email'] = $request->email;
			$data['mobile_number'] = $request->mobile_number;
			$data['aadhar_number'] = $request->aadhar_number;
			$hashed = Hash::make('Teamwebethics3!');
			$data['password'] = $hashed;
			$data['address'] = $request->address;			
			$data['role_id'] = $request->role_id;			
			$data['aadhar_number'] = str_replace('-','',$data['aadhar_number']);
			$dat = User::create($data);
			return Response::json(array(
			  'success'=>true,
			 ), 200);
		}
	}
	public function update_customer(UpdateCustomerRequest $request,$customer_id){
		$data=array();
		$result =array();
		$requestData = User::where('id',$customer_id);
		$stored_data = User::where('id',$customer_id)->first()->toArray();
		 
		if($request->ajax()){
			$data =array();
			$data['first_name']= $request->first_name;
			$data['last_name']= $request->last_name;
			$data['mobile_number'] = $request->mobile_number;
			$data['aadhar_number'] = $request->aadhar_number;
			$data['address'] = $request->address;
			$data['role_id'] = $request->role_id;		
			$requestData->update($data);
			
			//UPDATE PROFILE EVENT LOG END  
			$result['success'] = true;
			$result['full_name'] = $request->first_name.' '.$request->last_name;
			
			return Response::json($result, 200);
		}
	}
	
	public function customer_create()
    {
		access_denied_user('customer_create');
		$roles = Role::WhereNotIn('id',[1,3])->get();
		$view = view("modal.customerCreate",compact('roles'))->render();
		$success = true;

        return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	
	
}
?>