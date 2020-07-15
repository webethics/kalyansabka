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

class CustomersController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function customers(Request $request)
    {
		
		$request->role_id = 1;
        $customers = $this->customer_search($request,'');
		$roles = Role::all();
        if(!is_object($customers)) return $customers;
        if ($request->ajax()) {
            return view('customers.customersPagination', compact('customers','roles'));
        }
        return view('customers.customers',compact('customers','roles'));	
	}
	
	public function customer_search($request,$user_id)
	{
		$number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$customers = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $customers;
	}
	public function customer_edit($user_id)
    {
		
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
	
	
}
?>