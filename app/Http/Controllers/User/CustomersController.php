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
use App\Models\StateHeads;
use App\Models\DistrictHeads;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Session;
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
		
        $customers_data = $this->customer_search($request,$pagination=true);
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
	
	public function customer_search($request,$pagination)
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
		
		if($pagination == true){
			$customers = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$customers = $result->orderBy('created_at', 'desc')->get();
		}
		
		
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
			$data['state_id'] = $request->state;
			$data['district_id'] = $request->district;
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
			$data['state_id'] = $request->state;
			$data['district_id'] = $request->district;
			//echo '<pre>';print_r($data);die;
			//$data['role_id'] = $request->role_id;		
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
	
	public function customer_delete($customer_id)
    {
		access_denied_user('customer_delete');
		if($customer_id){
			$main_customer  = User::where('id',$customer_id)->first();
			if($main_customer){
				User::where('id',$customer_id)->delete();
				$result =array('success' => true);	
				return Response::json($result, 200);
			}else{
				$result =array('success' => false);	
				return Response::json($result, 200);
			}
			
		}
	}
	public function export_customers(Request $request)
	{
		$customers_data = $this->customer_search($request,$pagination = false);
		
		$customers  = $customers_data['customers'];
		
		if($customers && count($customers) > 0){
			$records = [];
			foreach ($customers as $key => $customer) {
				$records[$key]['sl_no'] = ++$key;
				$records[$key]['first_name'] = $customer->first_name;
				$records[$key]['last_name'] = $customer->last_name;
				$records[$key]['email'] = $customer->email;
				$records[$key]['phone'] = $customer->mobile_number;
				$records[$key]['aadhar'] = $customer->aadhar_number;
				$records[$key]['address'] =  $customer->address;
				$records[$key]['role'] =  $customer->role_id;
				$records[$key]['registraion'] =  date('d-m-Y h:i:s', strtotime($customer->created_at));
			}
			$header = ['S.No.', 'First Name','Last Name', 'Email','Mobile', 'Aadhar Number', 'Address', 'Role', 'Registration Date/Time'];
		

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
	
	public function mark_as_district_head($customer_id){
		$requestData = User::where('id',$customer_id);
		$stored_data = User::where('id',$customer_id)->first();
		
		if($stored_data->district_id){
			$district_id  = $stored_data->district_id;
			$stateHead = StateHeads::where('user_id',$customer_id)->first();
			$checkCurrentDistrictHead = DistrictHeads::where('district_id',$district_id)->first();
			
			$checkUserAsDistrictHead = DistrictHeads::where('user_id',$customer_id)->first();
			
			 if($checkUserAsDistrictHead){
				if($checkUserAsDistrictHead->district_id == $district_id){
					$result =array('success' => false,'message'=>'Customer is already assigned as District Head');	
					return Response::json($result, 200);
				}else{
					$result =array('success' => false,'message'=>'District Head is already assigned.');	
					return Response::json($result, 200);
				}
			}elseif($checkCurrentDistrictHead){
				$result =array('success' => false,'message'=>'District Head is already assigned for the Customer`s District');	
				return Response::json($result, 200);
			}elseif($stateHead){
				$result =array('success' => false,'message'=>'Customer is already assigned as the State Head');	
				return Response::json($result, 200);
			}else{
				$data = array();
				$data['district_id'] = $district_id;
				$data['user_id'] = $customer_id;
				DistrictHeads::create($data);
				
				$updateRoledate = array();
				$updateRoledate['role_id'] = 5;
				$requestData->update($updateRoledate);
				
				$result =array('success' => true,'message'=>'District Head assigned successfully.');	
				return Response::json($result, 200);
			}
		}else{
			$result =array('success' => true,'message'=>'No District is assigned to the customer.');	
			return Response::json($result, 200);
		}
		
		
	}

	public function mark_as_state_head($customer_id){
		$requestData = User::where('id',$customer_id);
		$stored_data = User::where('id',$customer_id)->first();
		
		if($stored_data->state_id){
			$state_id  = $stored_data->state_id;
			$districtHead = DistrictHeads::where('user_id',$customer_id)->first();
			
			$checkCurrentStateHead = StateHeads::where('state_id',$state_id)->first();
			
			$checkUserAsStateHead = StateHeads::where('user_id',$customer_id)->first();
			
			 if($checkUserAsStateHead){
				if($checkUserAsStateHead->state_id == $state_id){
					$result =array('success' => false,'message'=>'Customer is already assigned as State Head');	
					return Response::json($result, 200);
				}else{
					$result =array('success' => false,'message'=>'State Head is already assigned.');	
					return Response::json($result, 200);
				}
			}elseif($checkCurrentStateHead){
				$result =array('success' => false,'message'=>'State Head is already assigned for the Customer`s State');	
				return Response::json($result, 200);
			}elseif($districtHead){
				$result =array('success' => false,'message'=>'Customer is already assigned as the District Head');	
				return Response::json($result, 200);
			}else{
				$data = array();
				$data['state_id'] = $state_id;
				$data['user_id'] = $customer_id;
				StateHeads::create($data);
				$updateRoledate = array();
				$updateRoledate['role_id'] = 4;
				$requestData->update($updateRoledate);
				$result =array('success' => true,'message'=>'State Head assigned successfully.');	
				return Response::json($result, 200);
			}
		}else{
			$result =array('success' => true,'message'=>'No State is assigned to the customer.');	
			return Response::json($result, 200);
		}
	}
	
	public function downloadCertificate($customer_id){
		$headers = array(
			'Content-Type: application/pdf',
		);
		$file_name = 'FullPlan.pdf';
		$file_path = public_path().'/uploads/certificates';
		$filetopath=$file_path.'/'.$file_name;
		//echo $filetopath;die;
		return response()->download($filetopath,$file_name,$headers);
	}
	public function manageCustomer($id){
		// edit user profile
	    $result = DB::table('users')->where('id', '=' , $id)->get();
	    //$email=$result[0]->email;
		
	    if (Auth::loginUsingId($id))
		{
			//Session::put('is_admin_login', '1');
			return redirect('account');
		}
		else
		{
			return redirect('/login');
		}
		//Session::put('user_id', $result[0]->id);
		
		//return redirect('dashboard');
	}
}
?>