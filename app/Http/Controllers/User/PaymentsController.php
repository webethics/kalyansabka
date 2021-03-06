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
use Session;
use DateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class PaymentsController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function withdrawls(Request $request)
    {
		access_denied_user('withdrawl_listing');
		$withdrawl_data = $this->withdrawl_search($request,$pagination=true);
		
		if($withdrawl_data['success']){
			$payments = $withdrawl_data['withdrawls'];
			$page_number =  $withdrawl_data['current_page'];
			
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($payments)) return $payments;
			if ($request->ajax()) {
				return view('payments.withdrawlsPagination', compact('payments','page_number','roles'));
			}
			return view('payments.withdrawl',compact('payments','page_number','roles'));	
		}else{
			return $withdrawl_data['message'];
		}
		
	}
	public function payments(Request $request)
    {
		access_denied_user('payment_listing');
		$balance = DB::table('users')->sum('price');
		
		$customers_data = $this->payments_search($request,$pagination=true);
		if($customers_data['success']){
			$payments = $customers_data['customers'];
			$page_number =  $customers_data['current_page'];
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($payments)) return $payments;
			if ($request->ajax()) {
				return view('payments.paymentsPagination', compact('payments','page_number','roles','balance'));
			}
			return view('payments.payments',compact('payments','page_number','roles','balance'));	
		}else{
			return $customers_data['message'];
		}
		
	}
	
	public function payments_search($request,$pagination)
	{
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$mobile = $request->mobile_number;
		$aadhaar = $request->aadhar_number;
		$age_from = $request->age_from;
		$age_to = $request->age_to;
		
		//$result = User::where(`1`, '=', `1`);
		$result = UserPayment::with('user');
			
		if($first_name!='' || $last_name!='' || $start_date!='' || $end_date!='' || $email!='' || $mobile!='' || $aadhaar!='' || $age_from!='' || $age_to!=''){
			
			if($start_date!= '' || $end_date!=''){
				if(empty($end_date))
					$end_date = date('Y-m-d');
				
				if((($start_date!= '' && $end_date=='') || ($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
					
					$data = array();
					$data['success'] = false;
					$data['message'] = "date_error";
					return $data; 
				}
			}
			if($age_from!= '' || $age_to!=''){
				if((($age_from!= '' && $age_to=='') || ($age_from== '' && $age_to!='')) || ($age_from >= $age_to)){	
					$data = array();
					$data['success'] = false;
					$data['message'] = "age_error";
					return $data; 
				}else{
					//$result->whereBetween('age', array($age_from, $age_to));
					$result->whereHas('user', function (Builder $query) use ($age_from,$age_to) {
					    $query->whereBetween('age', array($age_from, $age_to));
					});
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
				//$result->where('email','LIKE',$email_q);
				$result->whereHas('user', function (Builder $query) use ($email_q) {
					$query->where('email','LIKE',$email_q);
				});
			} 
			
			$first_name_s = '%' . $first_name . '%';
			$last_name_s = '%' . $last_name . '%';
			
			// check name 
			if(isset($first_name) && !empty($first_name)){
				//$result->where('first_name','LIKE',$first_name_s);
				$result->whereHas('user', function (Builder $query) use ($first_name_s) {
					$query->where('first_name','LIKE',$first_name_s);
				});
			}
			if(isset($last_name) && !empty($last_name)){
				//$result->where('last_name','LIKE',$last_name_s);
				$result->whereHas('user', function (Builder $query) use ($last_name_s) {
					$query->where('last_name','LIKE',$last_name_s);
				});
			}
		 	if(isset($mobile) && !empty($mobile)){
				//$result->where('mobile_number','=',$mobile);
				$result->whereHas('user', function (Builder $query) use ($mobile)  {
					$query->where('mobile_number','=',$mobile);
				});
			}
		 	if(isset($aadhaar) && !empty($aadhaar)){
				//$result->where('aadhar_number','LIKE',$aadhaar);
				$result->whereHas('user', function (Builder $query) use ($aadhaar) {
					$query->where('aadhar_number','LIKE',$aadhaar);
				});
			}
		 	
		}
		
		
		//$result->where('role_id', '!=', 1)->where('role_id', '!=', 2);
		$result->whereHas('user', function (Builder $query) {
			$query->where('role_id', '!=', 1)->where('role_id', '!=', 2);
		});
		//echo $result->orderBy('created_at', 'desc')->toSql();die;
		
		if($pagination == true){
			$customers = $result->orderBy('id', 'desc')->paginate($number_of_records);
		}else{
			$customers = $result->orderBy('id', 'desc')->get();
		}
		
		
		$data = array();
		$data['success'] = true;
		$data['customers'] = $customers;
		$data['current_page'] = $page_number;
		return $data;
		
		/* $number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$payments = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $payments; */
	}
	public function withdrawl_search($request,$pagination)
	{
		$page_number = $request->page;
		
		$number_of_records =$this->per_page;
		
		$result = WithdrawlRequest::where(`1`, '=', `1`)->with('user');	
			
		$first_name = $request->first_name;
		$last_name = $request->last_name;
		$email = $request->email;
		$role_id = $request->role_id;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$mobile = $request->mobile_number;
		$aadhaar = $request->aadhar_number;
		$gender = $request->gender;
		$habits = $request->habits;
		$covered_amount = $request->covered_amount;
		$age_from = $request->age_from;
		$age_to = $request->age_to;
		$status = $request->status;
		
		$result_of_ids = User::where(`1`, '=', `1`);
		
		if($first_name!='' || $last_name!='' || $start_date!='' || $end_date!='' || $email!='' || $mobile!='' || $aadhaar!='' || $age_from!='' || $age_to!=''){
			
			if($start_date!= '' || $end_date!=''){
				if(empty($end_date))
					$end_date = date('Y-m-d');
				
				if((($start_date!= '' && $end_date=='') || ($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
					
					$data = array();
					$data['success'] = false;
					$data['message'] = "date_error";
					return $data; 
				}
			}
			if($age_from!= '' || $age_to!=''){
				if((($age_from!= '' && $age_to=='') || ($age_from== '' && $age_to!='')) || ($age_from >= $age_to)){	
					$data = array();
					$data['success'] = false;
					$data['message'] = "age_error";
					return $data; 
				}else{
					$result_of_ids->whereBetween('age', array($age_from, $age_to));
				}
			}
			
			$start_date_c = date('Y-m-d',strtotime($start_date));
			$end_date_c= date('Y-m-d',strtotime($end_date));
			
			if(!empty($start_date) &&  !empty($end_date)){
				$result_of_ids->where(function($q) use ($start_date_c,$end_date_c) {
				$q->whereDate('created_at','>=' ,$start_date_c);
				$q->whereDate('created_at','<=', $end_date_c );
			  });
			} 
			
			
			
			$email_q = '%' . $request->email .'%';
			// check email 
			if(isset($email) && !empty($email)){
				$result_of_ids->where('email','LIKE',$email_q);
			} 
			
			$first_name_s = '%' . $first_name . '%';
			$last_name_s = '%' . $last_name . '%';
			$habits_s = '%' . $habits . '%';
			
			// check name 
			if(isset($first_name) && !empty($first_name)){
				$result_of_ids->where('first_name','LIKE',$first_name_s);
			}
			if(isset($last_name) && !empty($last_name)){
				$result_of_ids->where('last_name','LIKE',$last_name_s);
			}
		 	if(isset($mobile) && !empty($mobile)){
				$result_of_ids->where('mobile_number','=',$mobile);
			}
		 	if(isset($aadhaar) && !empty($aadhaar)){
				$result_of_ids->where('aadhar_number','LIKE',$aadhaar);
			}
		 	
		}
		$result_of_ids->where('role_id', '!=', 1);
		
		$user_ids = $result_of_ids->select('id')->get();
		
		$eachids = array();
		foreach($user_ids as $id){
			$eachids[] = $id->id;
		}
		
		if($status != ''){
			$result->where('status',$status);
		}
		
		if($user_ids){
			$result->whereIN('user_id',$eachids);
		}
		//print_r($result);
		
		if($pagination == true){
			$withdrawls = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$withdrawls = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['success'] = true;
		$data['withdrawls'] = $withdrawls;
		$data['current_page'] = $page_number;
		return $data;
		
	}
	
	public function export_withdrawls(Request $request){
		$withdrawl_data = $this->withdrawl_search($request,$pagination = false);
		
		$withdrawls  = $withdrawl_data['withdrawls'];
		
		if($withdrawls && count($withdrawls) > 0){
			$records = [];
			foreach ($withdrawls as $key => $withdrawl) {
				$records[$key]['sl_no'] = ++$key;
				$records[$key]['first_name'] = $withdrawl->user->first_name;
				$records[$key]['last_name'] = $withdrawl->user->last_name;
				$records[$key]['email'] = $withdrawl->user->email;
				$records[$key]['phone'] = $withdrawl->user->mobile_number;
				$records[$key]['aadhar'] = $withdrawl->user->aadhar_number;
				$records[$key]['address'] =  $withdrawl->user->address;
				$records[$key]['amount'] =  $withdrawl->amount_requested;
				$records[$key]['status'] =  $withdrawl->status == 0 ? 'Pending' : 'Paid';
				
				$records[$key]['created'] =  date('d-m-Y h:i:s', strtotime($withdrawl->created_at));
			}
			$header = ['S.No.', 'First Name','Last Name', 'Email','Mobile', 'Aadhar Number', 'Address', 'Amount', 'Status', 'Registration Date/Time'];
		

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
	
	public function export_payments(Request $request){
		$payments_data = $this->payments_search($request,$pagination = false);
		$payments  = $payments_data['customers'];
		
		if($payments && count($payments) > 0){
			$records = [];
			foreach ($payments as $key => $payment) {
				$records[$key]['sl_no'] = ++$key;
				$records[$key]['first_name'] = $payment->user->first_name;
				$records[$key]['last_name'] = $payment->user->last_name;
				$records[$key]['email'] = $payment->user->email;
				$records[$key]['phone'] = $payment->user->mobile_number;
				$records[$key]['aadhar'] = $payment->user->aadhar_number;
				$records[$key]['address'] =  $payment->user->address;
				$records[$key]['narration'] =  $payment->comment;
				$records[$key]['created'] =  date('d-m-Y h:i:s', strtotime($payment->created_at));
				$records[$key]['price'] =  $payment->amount;
			}
			$header = ['S.No.', 'First Name','Last Name', 'Email','Mobile', 'Aadhar Number', 'Address', 'Registration Date/Time','Amount(INR)'];
		

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
	
	public function export_customer_payments(Request $request){
		$payments_data = $this->customer_payments_search($request,$pagination = false);
		$payments  = $payments_data['payments'];
		
		if($payments && count($payments) > 0){
			$records = [];
			foreach ($payments as $key => $payment) {
				$records[$key]['sl_no'] = ++$key;
				$records[$key]['Date'] = date('d-m-Y h:i:s', strtotime($payment->created_at));
				if($payment->mode == 2){
					$records[$key]['Naration'] = $payment->comment;
				}elseif($payment->mode == 1){
					$records[$key]['Naration'] =  'Credited - Referral Commission for <b>'.$payment->user->full_name.'</b>';
				}
				$records[$key]['Deposits'] = $payment->mode == 1 ? "INR ".$payment->amount : '';
				$records[$key]['withdrawals'] =  $payment->mode == 2 ? "INR ".$payment->amount : '';
				$records[$key]['status'] = $payment->status == 0 ? 'Pending' : 'Completed';
				
			}
			$header = ['S.No.', 'Date','Naration', 'Deposits','Withdrawals', 'Status'];
		

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
	
	public function customer_payments(Request $request)
    {
    	/*check if admin user login and manage user with another tab, then login user by Id*/
    	if(!empty(Session::get('is_admin_login'))  && Session::get('is_admin_login') == 1 && !empty(Session::get('user_id'))){
    		Auth::loginUsingId(Session::get('user_id'));
    	}
		$user_id = Auth::id();
		$total_amount = Income::where('user_id',$user_id)->first();
		
        $customer_payment_data = $this->customer_payments_search($request,$pagination=true);
		
		$payment_deposited  = IncomeHistory::where('user_id', '=', $user_id)->where('mode',1)->sum('amount');
		$payment_deposited = number_format($payment_deposited,2); 
		$payment_withdrawaled  = IncomeHistory::where('user_id', '=', $user_id)->where('mode',2)->sum('amount');
		$payment_withdrawaled = number_format($payment_withdrawaled,2);
		if($customer_payment_data['success']){
			$payments = $customer_payment_data['payments'];
			//echo '<pre>';print_r($payments->toArray());die;
			$page_number =  $customer_payment_data['current_page'];
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($payments)) return $payments;
			if ($request->ajax()) {
				return view('payments.customerPaymentsPagination', compact('payments','page_number','roles','total_amount','payment_deposited','payment_withdrawaled'));
			}
			return view('payments.customer-payments',compact('payments','page_number','roles','total_amount','payment_deposited','payment_withdrawaled'));	
		}else{
			return $customer_payment_data['message'];
		}
	}
	
	public function customer_payments_search($request,$pagination)
	{
		
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$user_id = Auth::id();
			
		$payment_type = $request->payment_type;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		$status = $request->status;
		
		$result = IncomeHistory::where('user_id', '=', $user_id)->with('user');
		
		if($payment_type!='' || $status!='' || $start_date!='' || $end_date!=''){
			
			if($start_date!= '' || $end_date!=''){
				if(empty($end_date))
					$end_date = date('Y-m-d');
				
				if((($start_date!= '' && $end_date=='') || ($start_date== '' && $end_date!='')) || (strtotime($start_date) >= strtotime($end_date))){	
					
					$data = array();
					$data['success'] = false;
					$data['message'] = "date_error";
					return $data; 
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
			
			if(isset($payment_type) && !empty($payment_type)){
				$result->where('mode','=',$payment_type);
			}
			
		 /* 	if(isset($status) && !empty($status)){
				$result->where('status','=',$status);
			} */
			if($status != ''){
				$result->where('status',$status);
			}
		 	
		 	
		}
		
		//print_r($result);
		$data =  $result->orderBy('created_at', 'desc')->get();
		//echo '<pre>';print_r($data->toArray());die;
		if($pagination == true){
			$payments = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$payments = $result->orderBy('created_at', 'desc')->get();
		}
		
		$data = array();
		$data['success'] = true;
		$data['payments'] = $payments;
		$data['current_page'] = $page_number;
		return $data;
		
		/* 
		
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		$user_id = Auth::id();
		$result = IncomeHistory::where('user_id', '=', $user_id)->with('user');
		$payments = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		//echo '<pre>';print_r($payments->toArray());die;
		$data = array();
		$data['success'] = true;
		$data['payments'] = $payments;
		$data['current_page'] = $page_number;
		return $data; */
	}
	function get_finacial_year_range() {
		$year = date('Y');
		$month = date('m');
		if($month<4){
			$year = $year-1;
		}
		$start_date = date('Y-m-d',strtotime(($year).'-04-01'));
		$end_date = date('Y-m-d',strtotime(($year+1).'-03-31'));
		$response = array('start_date' => $start_date, 'end_date' => $end_date);
		return $response;

	}
	public function payment_edit($payment_id)
    {
		
		access_denied_user('payment_edit');
        $request = WithdrawlRequest::where('id',$payment_id)->with('user','request_changes')->first();
		
		$user_id = $request->user_id;
		
		// total withdarawl amount till now
		$getAllWithdrawls = IncomeHistory::where('user_id',$user_id)->where('mode',2)->where('status',1)->sum('amount');
		$total_amount_withdrawal_till_now = round($getAllWithdrawls);
		
		
		// total withdarawl amount in current finacial year
		$get_finacial= $this->get_finacial_year_range();
		$start_date_c = date('Y-m-d',strtotime($get_finacial['start_date']));
		$end_date_c = date('Y-m-d',strtotime($get_finacial['end_date']));
		$amountWithdrawlthisfinancialyear = IncomeHistory::where('user_id',$user_id)->where('mode',2)->where('status',1);
		$amountWithdrawlthisfinancialyear->where(function($q) use ($start_date_c,$end_date_c) {
			$q->whereDate('created_at','>=' ,$start_date_c);
			$q->whereDate('created_at','<=', $end_date_c );
		});
		$finacial_year_data = $amountWithdrawlthisfinancialyear->sum('amount');
		$finacial_year_data = round($finacial_year_data);
		
		//trasaction Details
		$transaction_details =  WithdrawlRequest::where('user_id',$user_id)->where('status',1)->get();
		$allrequestforuser = count($transaction_details);
		
		$roles = Role::all();
		if($request){
			
			$view = view("modal.paymentEdit",compact('request','roles','total_amount_withdrawal_till_now','finacial_year_data','allrequestforuser','transaction_details'))->render();
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
	public function withdrawl_request(Request $request,$user_id){
		
		$get_current_request = WithdrawlRequest::where('user_id',$user_id)->where('status',0)->first();
		
		if(!$get_current_request){
			$withdrawldata = array();
			$generated_trasaction_id = getToken(9);
			$withdrawldata['user_id']  = $user_id;
			$withdrawldata['mode']  = 2;
			$withdrawldata['status']  = 0;
			$withdrawldata['amount']  = $request->amount;
			$withdrawldata['transaction_id']  = $generated_trasaction_id;
			$withdrawldata['comment']  = 'Withdrawal Requested for Amount INR '.$request->amount;	
			$history_id = IncomeHistory::create($withdrawldata);
			
			if($history_id->id){
				$data['user_id'] =  $user_id;
				$data['amount_requested'] =  $request->amount;
				$data['status'] =  0;
				$data['transaction_id'] = $generated_trasaction_id;
				$data['income_history_id'] = $history_id->id;
				$return = WithdrawlRequest::create($data);
			}
			return Response::json(array(
			  'success'=>true,
			), 200);
		}else{
			return Response::json(array(
			  'success'=>false,
			  'message'=>'Your already submit a request for withdrawal.'
			), 200);
		}
		
	}
	
	public function confirmPaymentModal(Request $request)
	{
		$id = $request->id;
		$accountDetails = UserBankDetails::where('user_id',$id)->first();
		if($accountDetails){
			$roleIdArr = Config::get('constant.role_id');
			$confirm_message =$request->confirm_message;
			$confirm_message_1 =$request->confirm_message_1;
			$leftButtonName =$request->leftButtonName;
			$leftButtonId =$request->leftButtonId;
			$leftButtonCls =$request->leftButtonCls;
			$amountRequested =$request->amount_requested;
			$id = $request->id;
			
		}else{
			$confirm_message =$request->confirm_message_2;
			$confirm_message_1 =$request->confirm_message_3;
			$leftButtonName =$request->leftButtonName_1;
			$leftButtonId =$request->leftButtonId_1;
			$leftButtonCls =$request->leftButtonCls;
			$id = $request->id;
		
		}
		if ($request->ajax()) {
			return view('modal.confirmPaymentModal', compact('id','confirm_message','confirm_message_1','leftButtonName','leftButtonId','leftButtonCls','amountRequested'));
		} 
		

	}
	
	function payment_update_request(UpdateWithdawalRequest $request,$request_id){
		$getRequest = WithdrawlRequest::where('id',$request_id)->first();
		if($getRequest){
			
			$requestData = WithdrawlRequest::where('id',$request_id);
			$data['status'] = $request->status;
			$data['id'] = $request->request_id;
			if($request->tds_deduction_amount > $request->withdrawal_amount){
				
				return Response::json(array(
						  'success'=>false,
						  'message'=>"TDS Dedcution amount can not be greater than Withdrawal Amount"
						), 200);
			}
			if($data['status'] == 1){
				
				$incomehistory_data = IncomeHistory::where('id',$request->income_history_id)->first();
				$withdarawl_amount = $request->withdrawal_amount;
				$calculated_tds = 0;
				
				
				if($request->deduction_type == 'amount'){
					$tds_deduction_1 = $request->tds_deduction_amount;
					$calculated_tds =  $tds_deduction_1;
					$income1_data['user_id']  = $request->user_id;
					$income1_data['mode']  = 2;
					$income1_data['status']  = 1;
					$income1_data['amount']  = $calculated_tds;
					$income1_data['transaction_id'] = 	$request->transaction_id;
					$income1_data['comment']  = 'TDS Deduction on Withdrawal amount INR '.$withdarawl_amount;	
					//IncomeHistory::create($income1_data);
				}
				
				if($request->deduction_type == 'percentage'){
					$tds_deduction_2 = $request->tds_deduction_percentage;
					$calculated_tds =  ($withdarawl_amount * $tds_deduction_2 )/100;
					$income1_data['user_id']  = $request->user_id;
					$income1_data['mode']  = 2;
					$income1_data['status']  = 1;
					$income1_data['amount']  = $calculated_tds;
					$income1_data['transaction_id'] = 	$request->transaction_id;
					$income1_data['comment']  = 'TDS Deduction on Withdrawal amount INR '.$withdarawl_amount;	
					
				}
				
				
				
				
				$admin_charges = $request->admin_charges;
				$calculated_admin_charges =  ($withdarawl_amount * $admin_charges )/100;
				$income2_data['user_id']  = $request->user_id;
				$income2_data['mode']  = 2;
				$income2_data['status']  = 1;
				$income2_data['transaction_id'] = 	$request->transaction_id;
				$income2_data['amount']  = $calculated_admin_charges;
				$income2_data['comment']  = 'Admin Charges on Withdrawal amount INR '.$withdarawl_amount;	
				
				if($calculated_admin_charges + $calculated_tds >  $withdarawl_amount){
					return Response::json(array(
						  'success'=>false,
						  'message'=>"TDS Dedcution amount can not be greater than Withdrawal Amount"
						), 200);
				}else{
					if($request->deduction_type == 'percentage'){
						IncomeHistory::create($income1_data);
					}
					if($request->deduction_type == 'amount'){
						IncomeHistory::create($income1_data);
					}
					IncomeHistory::create($income2_data);
					$incomehistory_data->user_id  = $request->user_id;
					$incomehistory_data->mode  = 2;
					$incomehistory_data->status  = 1;
					$incomehistory_data->amount  = $withdarawl_amount - $calculated_tds - $calculated_admin_charges;
					$incomehistory_data->comment  = 'Withdrawal Requested for Amount INR '.$withdarawl_amount;
					$incomehistory_data->save();
					
					
					$tds_deduction = $request->tds_dedcution;
					$withdarawl_amount = $request->withdrawal_amount;
					$admin_charges = $request->admin_charges;
					
					$calculated_admin_charges =  ($withdarawl_amount * $admin_charges )/100; 
					$deposit_to_bank = $withdarawl_amount - $calculated_tds - $calculated_admin_charges;
					$request_data['tds_deduction'] = $calculated_tds;
					$request_data['admin_charges'] = $calculated_admin_charges;
					$request_data['deposit_to_bank'] = $deposit_to_bank;
					$request_data['request_id'] = 	$request->income_history_id;
					$request_data['withdrawal_amount'] = 	$request->withdrawal_amount;
					$request_data['deduction_type'] = 	$request->deduction_type;
					$request_data['tds_deduction_amount'] = 	$request->tds_deduction_amount?$request->tds_deduction_amount:'';
					$request_data['tds_deduction_percentage'] = 	$request->tds_deduction_percentage?$request->tds_deduction_percentage:'';
					$request_data['admin_percent'] = 	$request->admin_charges;
					$request_data['user_id'] = 	$request->user_id;
					$request_data['transaction_id'] = 	$request->transaction_id;
					
					$update = $requestData->update($data);
					if($update){
						WithdrawalRequestCharges::create($request_data);
						return Response::json(array(
						  'success'=>true,
						  'message'=>"Request Compleated Successfuly."
						), 200);
					}else{
						return Response::json(array(
						  'success'=>false,
						  'message'=>"Some issue in compleating the request."
						), 200);
					}
				}
				
				
				
				
			}else{
				return Response::json(array(
					  'success'=>false,
					  'message'=>"Payment Status Must be Paid."
					), 200);
			} 
		}else{
			return Response::json(array(
					  'success'=>false,
					  'message'=>"No data found associated with this request."
					), 200);
		}
		
	}
	
}
?>