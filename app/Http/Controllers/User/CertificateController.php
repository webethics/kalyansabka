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
        $certificates = $this->certificate_search($request,'');
		$roles = Role::all();
        if(!is_object($certificates)) return $certificates;
        if ($request->ajax()) {
            return view('certificates.certificatesPagination', compact('certificates','roles'));
        }
        return view('certificates.certificates',compact('certificates','roles'));	
	}
	
	public function certificate_search($request,$user_id)
	{
		$number_of_records =$this->per_page;
		$result = User::where(`1`, '=', `1`);	
		$certificates = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		return $certificates;
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
			$view = view("modal.requestEdit",compact('user','roles'))->render();
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