<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Config;
use App\Models\Setting;
use App\Models\User;
use App\Models\EmailTemplate;
use Auth;
use Session;
use App\Models\Role;
use App\Models\AuditLog;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
	
	  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$this->middleware('guest')->except('logout');
	 //  $this->middleware('auth');
	
    }
	
	
	
	public function login(Request $request)
    {   
		
        $input = $request->all();
		$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile_number';
		
		if($field == 'email'){
			$rules = array('login' => 'required',
				   'password' => 'required',
				   );
		}
		if($field == 'mobile_number'){
			$rules = array('login' => 'required',
				   'password' => 'required',
				   );
		}
		

		$validator = Validator::make($request->input(), $rules);
		if ($validator->fails())
		{
			return redirect('login')->withErrors($validator)->withInput($request->except('password'));
		}else
		{
			
			if(Auth::attempt(array($field=> $request->input('login'), 'password' => $input['password'])))
			{ 
		        //IF STATUS IS NOT ACTIVE 
				if(Auth::check() && Auth::user()->verify_token !=NULL){
					//EVENT FAILED
					Auth::logout();
					return redirect('/login')->with('error', 'Your account is not verified.Please check your email and verify your account.');
				}else if(Auth::check() && Auth::user()->status == 0){ 
					//IF STATUS IS NOT ACTIVE 
					//EVENT FAILED
					Auth::logout();
					return redirect('/login')->with('error', 'Your account is deactivated.');
				}
				
				if(Auth::check() && Auth::user()->status == 1){
					$user = Auth::user();
					$role_id =  $user->role_id;
					//$role_id = Config::get('constant.role_id');
					/*flag variables*/
					$is_admin = 0;

					if(!empty($role_id)){
						$fetchUserRole = Role::where('id',$role_id)->first();
						/*If data present*/
						if(!is_null($fetchUserRole) && ($fetchUserRole->count())>0){
							$user_role = $fetchUserRole->slug;
							if($user_role == 'super-admin'){
								// set session value
								Session::put('is_admin_login', '1');
								Session::put('admin_user_id', $user->id);
								Session::put('user_id','');
							}else{
								Session::put('is_admin_login', '0');
								Session::put('admin_user_id','');
								Session::put('user_id',$user->id);
							}
						}
		
					}
					
					
					/* Auth::login($user, true);
					Session::put('user',$user); */
					/* if($role_id['SUPER_ADMIN']== current_user_role_id()){
					  return redirect('account');	 
					} 
					if($role_id['INDIA_HEAD']== current_user_role_id()){
					  return redirect('account');	 
					}  */
					
				}else{
					
					return redirect()->route('login');
				}
				
			  /* USE/ANALYST/USER-ADMIN LOGIN SETTING ADMIN ENABLE DOUBLE AUTHENTICATION  */ 
			  $setting = Setting::where('user_id',1)->get();
			  //pr($setting);
			  // IF DOUBLE AUTHENTICATION IS ON 
			  if($setting[0]->double_authentication){
				  /* Send OTP to User in email or phone */
				    $otp  = getToken(7); 
				    $usertData = User::where('id',$user->id);
					$data =array();
					$data['otp'] =$otp; 
					$usertData->update($data);
					$to  = $user->email; 
					//EMAIL REGISTER EMAIL TEMPLATE 
					$result = EmailTemplate::where('template_name','one_time_otp')->get();
					$subject = $result[0]->subject;
					$message_body = $result[0]->content;
					$uname = $user->first_name .' '.$user->last_name;
					$logo = url('/img/logo.png');
					
					$list = Array
					  ( 
						 '[NAME]' => $uname,
						 '[OTP]' => $otp,
						 '[LOGO]' => $logo,
					  );

					$find = array_keys($list);
					$replace = array_values($list);
					$message = str_ireplace($find, $replace, $message_body);
	
					$mail = send_email($to, $subject, $message); 
				
				 /*   */
				 return redirect('send-otp')
				->with('message','Please check email or phone for OTP.');
				  
			  }else{		
					
					// IF DOUBLE AUTHENTICATION IS OFF : ANALYST/ADMIN/USER/USER_ADMIN 
					 return redirect(redirect_route_name());
			  }
			}
			else{
				//EVENT FAILED
				
				return redirect()->route('login')
					->with('error','You have entered wrong details.');
			}
		}

    }
	
}
