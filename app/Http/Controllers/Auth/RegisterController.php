<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Config;
use App\Models\Setting;
use App\Models\User;
use App\Models\EmailTemplate;
use Auth;
use App\Models\AuditLog;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use QrCode;
use Session;
use Illuminate\Auth\Events\Registered;
use Response;
use DB;
use DateTime;
use App\Models\Plan;
use App\Http\Requests\CreateUserRequest;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
	

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
	
        //$this->middleware('guest');
    }
	
	
	public function showRegistrationForm()
	{
		
		return view('auth.register');	
		
	}
	
	
	
	public function checkemail(Request $req)
	{
		$email = $req->email;
		$emailcheck = DB::table('users')->where('email',$email)->count();
		if($emailcheck > 0)
		{
		 $result =array('success' => false,'msg'=>'The email has already been taken.');	
		}else{
			$result =array('success' => true,'msg'=>'');	
		}

		return Response::json($result, 200);
	}
	
	
	
	
	
	public function register(Request $request)
	{
		
		$this->validator($request->all())->validate();

		event(new Registered($user = $this->create($request->all())));

		$this->guard()->login($user);

		return $this->registered($request, $user)
							?: redirect($this->redirectPath());
	 } 
	 

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
	protected function validator(array $data)
    {
		$data['aadhar_number'] = str_replace('-','',$data['aadhar_number']);
		
        return Validator::make($data, [
            'first_name'     => [
                'required',
            ],
			'last_name'     => [
                'required',
            ],
			'login_password'    => [
				'required', 'regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/', 'min:6'
			],
			'login_password_confirmation'    => [
                'required','same:login_password',
            ],
			'email*' => [
				'required','email','unique:users'
			],
            'mobile_number'   => [
               'required','numeric','regex:/[0-9]{9}/','unique:users',
            ],
			'aadhar_number'   => [
               'required','unique:users'
            ], 
			'address'   => [
               'required',
            ],
			'date_of_birth'   => [
               'required',
            ], 
			'district'   => [
               'required',
            ],
			'state'   => [
               'required',
            ] ,
			'terms_and_condtions'   => [
               'required',
            ], 
			
			 
			
        ], [
				'aadhar_number.unique' => 'The aadhar number is already registered.',
				
			]);
    } 

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
		$data['aadhar_number'] = str_replace('-','',$data['aadhar_number']);
		//	echo '<pre>';print_r($data);die;
		$dat =  User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'aadhar_number' => $data['aadhar_number'],
            'mobile_number' => $data['mobile_number'],
            'email' => $data['email'],
            'password' => Hash::make($data['login_password']),
			'date_of_birth' => $data['date_of_birth'],
			'address' => $data['address'],
			'age' => $data['age'],
			'price' => $data['price'],
			'state_id' => $data['state'],
			'district_id' => $data['district'],
			'refered_by' => $data['refered_by'],
			'role_id' => 3,
			'status' => 1,
		]);
		
		if($dat){
			Session::flash('message', "Welcome to Kalyan Sabka. Please logged into your account and setup your profile.");
			return $dat;
		} 
		return redirect()->route('account'); 
    }
}
