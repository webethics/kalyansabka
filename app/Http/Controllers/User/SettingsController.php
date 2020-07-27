<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateEmailSettings;
use App\Http\Requests\UpdateSiteSettings;
use App\Http\Requests\UpdateCustomSiteSettings;
use Intervention\Image\Facades\Image;
use App\Models\User;
use App\Models\Setting;
use App\Models\SiteSetting;
use App\Models\UserDocuments;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Auth;
use Config;
use Response;
use Hash;
use File;
use Crypt;
class SettingsController extends Controller
{
	private $photos_path;
	private $custom_photos_path;
	public function __construct()
    {
		$this->photos_path = public_path('/uploads/logo/');
		$this->custom_photos_path = public_path('/uploads/documents/');
    }
   
	/*
	* SETTING LAYOUT 
	*/
    public function index()
    {
		access_denied_user('config_listing');
		$user_id = user_id();
		$settings =  Setting::where('id',1)->get()[0];
        return view('users.settings.create',compact('user_id','settings'));
    }
	
	/*
	* SITE SETTING LAYOUT 
	*/
    public function site_settings()
    {
		$user_id = user_id();
		$site_settings =  SiteSetting::where('user_id',$user_id)->first();
		//print_r($site_settings);die;
        return view('users.site_settings.create',compact('user_id','site_settings'));
    }
	
	/*
	* UPDATING SMTP AND EMAIL SETTINGS
	*/
    public function update_email_settings(UpdateEmailSettings $request, $user_id)
    {
		$requestData = Setting::where('id',1);
		if($request->ajax()){
			$data =array();
			$data['smtp_host']		= $request->smtp_host;
			$data['smtp_port']		= $request->smtp_port;
			$data['smtp_user']		= $request->smtp_user;
			$hashed = $this->urlsafe_b64encode($request->smtp_password);
			$data['smtp_password']	= $hashed;
			$data['from_email']		= $request->from_email;
			$data['from_name']		= $request->from_name;
			
			$requestData->update($data);
			$result =array(
				'success' => true
			);	
			
			return Response::json($result, 200);
		}
    }
	/*
	* UPDATING SITE AND OTHER SETTINGS
	*/
    public function update_site_settings(UpdatesiteSettings $request, $user_id)
    {
		$requestData = Setting::where('id',1);
		if($request->ajax()){
			$data =array();
			
			$data['site_title']			= $request->site_title;
			$data['double_authentication'] = ($request->two_factor_authentication)? 1 : 0;
			/* Below commented code is for future user */
			//$data['message_api_name']	= $request->api_name;
			//$data['message_api_key']	= $request->api_key; */
			$requestData->update($data);
			$result =array(
				'success' => true
			);	
			return Response::json($result, 200);
		}
    }
	/*
	* LOGO UPLOAD ON AJAX REQUEST
	*/
	public function uploadLogo(Request $request, $user_id){
		$requestData = Setting::where('id',1);
		if($request->ajax()){
			$data =array();
			$logo = $request->file('file');
			if (!is_dir($this->photos_path)) {
				mkdir($this->photos_path, 0777);
			}
			$settings =  Setting::where('id',1)->get()[0];
			if(!empty($settings->site_logo)){
				$file_path = $this->photos_path.$settings->site_logo;
				File::delete($file_path);
			}
			$randomString = sha1(date('YmdHis') . Str::random(30));
			$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
			$data['site_logo'] = $save_name;
			$requestData->update($data);
			$logo->move($this->photos_path, $save_name);
			$result =array(
				'success' => true,
				'filePath' => $this->photos_path,
				'name'=>$save_name
			);	
			return Response::json($result, 200);
			
		}
	}
	/*
	* FETCHING LOGO ON AJAX REQUEST
	*/
	public function getLogo(Request $request, $user_id){
		if($request->ajax()){
			$settings =  Setting::where('id',1)->get()[0];
			if(!empty($settings->site_logo)){				
				$file_path = $this->photos_path.$settings->site_logo;
				$fileSize =  File::size($file_path);
				$result =array(
					'success' => true,
					'name'=>$settings->site_logo,
					'size'=>$fileSize
				);	
			}else{
				$result =array(
					'msg' => 'Error'
				);
			}
			return Response::json($result, 200);
		}
	}
	/*
	* DELETING LOGO ON AJAX REQUEST
	*/
	public function deleteLogo(Request $request, $user_id){
		if($request->ajax()){
			$data =array();
			$rqst_file_name = $request->file_name;
			
			$requestData = Setting::where('id',1);
			$settings =  Setting::where('id',1)->get()[0];
			$file_path = $this->photos_path.$settings->site_logo;
			$db_file_name = $settings->site_logo;
			$fileSize =  File::size($file_path);
			if($db_file_name == $rqst_file_name){
				File::delete($file_path);
				$data['site_logo'] = '';
				$requestData->update($data);
				$result =array(
					'success' => true,
					'msg'=>'Logo deleted successfully.',
				);
			}else{
				$result =array(
					'msg'=>'Error',
				);
			}
			return Response::json($result, 200);
		}
	}
	
	/*
	* UPDATING SITE AND OTHER SETTINGS
	*/
    public function update_user_documents(UpdateCustomsiteSettings $request, $user_id)
    {
		
		if($request->ajax()){
			$data =array();
			
			
			$result =array(
				'success' => true,
				'msg'=>'Settings updated successfully.',
			);	
			return Response::json($result, 200);
		}
    }
	
	/*
	* LOGO UPLOAD ON AJAX REQUEST
	*/
	public function uploadCustomLogo(Request $request, $user_id,$type){
		$requestData = UserDocuments::where('user_id',$user_id);
		$data['user_id']  = $user_id;
		
		$documents = UserDocuments::where('user_id',$user_id)->first();
		
		if($documents){
			$requestData->update($data);
		}else{
			UserDocuments::create($data);
		}
		if($request->ajax()){
			$data =array();
			
			if (!is_dir($this->custom_photos_path)) {
				mkdir($this->custom_photos_path, 0777);
			}
			//$documents =  UserDocuments::where('user_id',$user_id)->first();
			if($type == 'aadhaar_front'){
				$logo = $request->file('file1');
				if(!empty($documents->aadhaar_front)){
					$file_path = $this->custom_photos_path.$documents->aadhaar_front;
					File::delete($file_path);
				}
				$randomString = sha1(date('YmdHis') . Str::random(30));
				$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
				$data['aadhaar_front'] = $save_name;
				$message  = "Aadhaar Card Front image successfully uploaded.";
			}
			
			if($type == 'aadhaar_back'){
				$logo = $request->file('file2');
				if(!empty($documents->aadhaar_back)){
					$file_path = $this->custom_photos_path.$documents->aadhaar_back;
					File::delete($file_path);
				}
				$randomString = sha1(date('YmdHis') . Str::random(30));
				$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
				$data['aadhaar_back'] = $save_name;
				$message  = "Aadhaar Card Back image successfully uploaded.";
			}
			if($type == 'pan_card'){
				$logo = $request->file('file3');
				if(!empty($documents->pan_card)){
					$file_path = $this->custom_photos_path.$documents->pan_card;
					File::delete($file_path);
				}
				$randomString = sha1(date('YmdHis') . Str::random(30));
				$save_name = $randomString . '.' . $logo->getClientOriginalExtension();
				$data['pan_card'] = $save_name;
				$message  = "Pan Card image successfully uploaded.";
			}
			
			
			$requestData->update($data);
			
			
			$logo->move($this->custom_photos_path, $save_name);
			$result =array(
				'success' => true,
				'filePath' => $this->custom_photos_path,
				'name'=>$save_name,
				'message'=>$message
			);	
			return Response::json($result, 200);
			
		}
	}
	/*
	* FETCHING LOGO ON AJAX REQUEST
	*/
	public function getCustomLogo(Request $request, $user_id,$type){
		if($request->ajax()){
			$documents =  UserDocuments::where('user_id',$user_id)->first();
			
			if($type == 'aadhaar_front'){
				if(!empty($documents->aadhaar_front)){				
					$file_path = $this->custom_photos_path.$documents->aadhaar_front;
					$fileSize =  File::size($file_path);
					$result =array(
						'success' => true,
						'name'=>$documents->aadhaar_front,
						'size'=>$fileSize
					);	
				}else{
					$result =array(
						'msg' => 'Error'
					);
				}
			}
			if($type == 'aadhaar_back'){
				if(!empty($documents->aadhaar_back)){				
					$file_path = $this->custom_photos_path.$documents->aadhaar_back;
					$fileSize =  File::size($file_path);
					$result =array(
						'success' => true,
						'name'=>$documents->aadhaar_back,
						'size'=>$fileSize
					);	
				}else{
					$result =array(
						'msg' => 'Error'
					);
				}
			}
			if($type == 'pan_card'){
				if(!empty($documents->pan_card)){				
					$file_path = $this->custom_photos_path.$documents->pan_card;
					$fileSize =  File::size($file_path);
					$result =array(
						'success' => true,
						'name'=>$documents->pan_card,
						'size'=>$fileSize
					);	
				}else{
					$result =array(
						'msg' => 'Error'
					);
				}
			}
			
			return Response::json($result, 200);
		}
	}
	/*
	* DELETING LOGO ON AJAX REQUEST
	*/
	public function deleteCustomLogo(Request $request, $user_id,$type){
		if($request->ajax()){
			$data =array();
			$rqst_file_name = $request->file_name;
			
			$requestData = UserDocuments::where('user_id',$user_id);
			$documents =  UserDocuments::where('user_id',$user_id)->get()[0];
			if($type == 'aadhaar_front'){
				$file_path = $this->custom_photos_path.$documents->aadhaar_front;
				$db_file_name = $documents->aadhaar_front;
				$fileSize =  File::size($file_path);
				if($db_file_name == $rqst_file_name){
					File::delete($file_path);
					$data['aadhaar_front'] = '';
					$requestData->update($data);
					$result =array(
						'success' => true,
						'msg'=>'Aadhaar Card front image deleted successfully.',
					);
				}else{
					$result =array(
						'msg'=>'Error',
					);
				}
			}
			if($type == 'aadhaar_back'){
				$file_path = $this->custom_photos_path.$documents->aadhaar_back;
				$db_file_name = $documents->aadhaar_back;
				$fileSize =  File::size($file_path);
				if($db_file_name == $rqst_file_name){
					File::delete($file_path);
					$data['aadhaar_back'] = '';
					$requestData->update($data);
					$result =array(
						'success' => true,
						'msg'=>'Aadhaar Card Back image deleted successfully.',
					);
				}else{
					$result =array(
						'msg'=>'Error',
					);
				}
			}
			if($type == 'pan_card'){
				$file_path = $this->custom_photos_path.$documents->pan_card;
				$db_file_name = $documents->pan_card;
				$fileSize =  File::size($file_path);
				if($db_file_name == $rqst_file_name){
					File::delete($file_path);
					$data['pan_card'] = '';
					$requestData->update($data);
					$result =array(
						'success' => true,
						'msg'=>'PAN Card deleted successfully.',
					);
				}else{
					$result =array(
						'msg'=>'Error',
					);
				}
			}
			
			return Response::json($result, 200);
		}
	}
	
	
	
	function urlsafe_b64encode($string)
	{
		$ciphering = "AES-128-CTR";
		$encryption_key = "GeeksforGeeks";
		$options = 0;
		$encryption_iv = '1234567891011121';
		return openssl_encrypt($string, $ciphering,$encryption_key, $options, $encryption_iv);
	}
}
