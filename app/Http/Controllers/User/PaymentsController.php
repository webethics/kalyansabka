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

use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class PaymentsController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function withdrawls(Request $request)
    {
		$request->role_id = 1;
        $payments = $this->withdrawl_search($request,'');
		$roles = Role::all();
        if(!is_object($payments)) return $payments;
        if ($request->ajax()) {
            return view('payments.withdrawlsPagination', compact('payments','roles'));
        }
        return view('payments.withdrawl',compact('payments','roles'));	
	
		
	}
	public function payments(Request $request)
    {
		$request->role_id = 1;
        $payments = $this->payments_search($request,'');
		$roles = Role::all();
        if(!is_object($payments)) return $payments;
        if ($request->ajax()) {
            return view('payments.paymentsPagination', compact('payments','roles'));
        }
        return view('payments.payments',compact('payments','roles'));	
	}
	
	public function payments_search($request,$user_id)
	{
		$number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$payments = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $payments;
	}
	public function withdrawl_search($request,$user_id)
	{
		$number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$withdrawls = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $withdrawls;
	}
	
	
	public function customer_payments(Request $request)
    {
		$request->role_id = 1;
        $payments = $this->customer_payments_search($request,'');
		$roles = Role::all();
        if(!is_object($payments)) return $payments;
        if ($request->ajax()) {
            return view('payments.customerPaymentsPagination', compact('payments','roles'));
        }
        return view('payments.customer-payments',compact('payments','roles'));	
	}
	
	public function customer_payments_search($request,$user_id)
	{
		$number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$payments = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $payments;
	}
	
	public function payment_edit($user_id)
    {
		
        $user = User::where('id',$user_id)->get();
		$roles = Role::all();
		if(count($user)>0){
			$user =$user[0];
			$view = view("modal.paymentEdit",compact('user','roles'))->render();
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