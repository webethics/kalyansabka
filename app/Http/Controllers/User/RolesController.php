<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\CdrGroup;
use App\Models\EmailTemplate;
use App\Models\PermissionList;
use App\Models\RolesPermission;
use App\Models\CityLists;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class RolesController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function roles()
    {
		$roles = Role::all();
        return view('roles.roles',compact('roles'));	
	}
	
	public function roles_edit($role_id)
    {
		
        $roles = Role::where('id',$role_id)->with('rolePermissions')->first();
		
		$permission_array = array();
		foreach($roles->rolePermissions as $permission){
			 $permission_array[] = $permission->permission_id;
			 $roles->permissionArray = $permission_array;
		}
		
		$listPermission = PermissionList::all();
		if($roles){
			$view = view("modal.roleEdit",compact('roles','listPermission'))->render();
			$success = true;
		}else{
			$view = '';
			$success = false;
		}
		
		return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	
	public function role_create()
    {
		$roles = Role::all();
		$listPermission = PermissionList::all();
		$view = view("modal.roleCreate",compact('roles','listPermission'))->render();
		$success = true;

        return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	
	public function role_permission_update(UpdateRoleRequest $request)
    {
		$roles = Role::all();
		$listPermission = PermissionList::all();
		$view = view("modal.roleCreate",compact('roles','listPermission'))->render();
		
		if($request->ajax()){
			
			$data =array();
			$rolesData = Role::where('id',$request->role_id);
			$data['title']	= $request->title;
			$data['slug']	= $this->slugify($request->title);
			//$data['id']		= $request->role_id;
			if($data['title']){
				$roledata = $rolesData->update($data);
				if($roledata){
					RolesPermission::where('role_id',$request->role_id)->delete();
					$permission_data = $request->permissions;
					foreach($permission_data as $value){
						$final_permission['role_id'] = $request->role_id;
						$final_permission['permission_id'] = $value;
						$permission_data_final = RolesPermission::create($final_permission);
					}
				}
			}
			 return Response::json(array(
					  'success'=>true,
					  'data'=>$view
					), 200);
		
		}

       
    }
	public function role_permission_create(CreateRoleRequest $request)
    {
		if($request->ajax()){
			
			$data =array();
			$data['title']	= $request->title;
			$data['slug']	= $this->slugify($request->title);
			if($data['title']){
				$roledata = Role::create($data);
				if($roledata){
					$permission_data = $request->permissions;
					foreach($permission_data as $value){
						$final_permission['role_id'] = $roledata->id;
						$final_permission['permission_id'] = $value;
						$permission_data_final = RolesPermission::create($final_permission);
					}
				}
			}
			return Response::json(array(
			  'success'=>true,
			 ), 200);
			 
		
		}
    }
	function slugify($string, $replace = array(), $delimiter = '-') {
		// https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
		if (!extension_loaded('iconv')) {
		throw new Exception('iconv module not loaded');
		}
		// Save the old locale and set the new locale to UTF-8
		$oldLocale = setlocale(LC_ALL, '0');
		setlocale(LC_ALL, 'en_US.UTF-8');
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
		if (!empty($replace)) {
		$clean = str_replace((array) $replace, ' ', $clean);
		}
		// $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower($clean);
		$clean = preg_replace("/[\/_|+ -!@#$%^&*()]+/", $delimiter, $clean);
		$clean = trim($clean, $delimiter);
		// Revert back to the old locale
		setlocale(LC_ALL, $oldLocale);
		return $clean;
	}
	
	
}	