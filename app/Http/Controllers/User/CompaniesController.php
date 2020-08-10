<?php 
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
//use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
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
use App\Models\Company;
use League\Csv\Writer;	
use Auth;
use Config;
use Response;
use Session;
use Hash;
use DB;
use DateTime;
use Carbon\Carbon;

class CompaniesController extends Controller
{
	protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }
	
	public function companies(Request $request)
    {
		
		access_denied_user('companies_listing');
		
        $companies_data = $this->company_search($request,$pagination=true);
		if($companies_data['success']){
			$companies = $companies_data['companies'];
			$page_number =  $companies_data['current_page'];
			if(empty($page_number))
				$page_number = 1;
			$roles = Role::all();
			if(!is_object($companies)) return $companies;
			if ($request->ajax()) {
				return view('companies.companiesPagination', compact('companies','page_number'));
			}
			return view('companies.companies',compact('companies','page_number'));	
		}else{
			return $companies_data['message'];
		}
		
		
	}
	
	public function company_search($request,$pagination)
	{
		
		$page_number = $request->page;
		$number_of_records =$this->per_page;
		
		$result = Company::where(`1`, '=', `1`);
		if($pagination == true){
			$companies = $result->orderBy('created_at', 'desc')->paginate($number_of_records);
		}else{
			$companies = $result->orderBy('created_at', 'desc')->get();
		}
		
		
		$data = array();
		$data['success'] = true;
		$data['companies'] = $companies;
		$data['current_page'] = $page_number;
		return $data;
	}
	
	public function company_edit($company_id)
    {
		access_denied_user('companies_edit');
        $company = Company::where('id',$company_id)->get();
		if(count($company)>0){
			$company =$company[0];
			$view = view("modal.companyEdit",compact('company'))->render();
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
	public function compnay_create_new(CreateCompanyRequest $request){
		if($request->ajax()){
			$data =array();
			$data['name']	= $request->name;
			$data['slug'] = $this->slugify($request->name); 
		
			$dat = Company::create($data);
			return Response::json(array(
			  'success'=>true,
			 ), 200);
		}
	}
	public function update_company(UpdateCompanyRequest $request,$company_id){
		$data=array();
		$result =array();
		$requestData = Company::where('id',$company_id);
		$stored_data = Company::where('id',$company_id)->first();
		
		if($request->ajax()){
			$data =array();
			$data['name']= $request->name;
			$data['slug'] = $this->slugify($request->name);
			
			$requestData->update($data);
			$result['success'] = true;
			//UPDATE PROFILE EVENT LOG END  
			
			$result['name'] = $request->name;
			
			return Response::json($result, 200);
		}
	}
	
	public function company_create()
    {
		access_denied_user('companies_create');
		
		$view = view("modal.companyCreate")->render();
		$success = true;

        return Response::json(array(
		  'success'=>$success,
		  'data'=>$view
		 ), 200);
    }
	
	public function company_delete($company_id)
    {
		access_denied_user('companies_delete');
		if($company_id){
			$main_company  = User::where('company_id',$company_id)->first();
			if(!$main_company){
				Company::where('id',$company_id)->delete();
				$result =array('success' => true);	
				return Response::json($result, 200);
			}else{
				$result =array('success' => false,'message'=>'This Company has user listed in it. So it can not be deleted.');	
				return Response::json($result, 200);
			}
			
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
?>