<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use Config;
use Response;

class CommissionController extends Controller
{
    protected $per_page;
	public function __construct()
    {
	    
        $this->per_page = Config::get('constant.per_page');
    }

    public function index(Request $request)
    {
		access_denied_user('commission_listing');
		$number_of_records =$this->per_page;
		$commissions = Commission::paginate($number_of_records);
		echo $page_number = $request->page;
		if(empty($page_number))
			$page_number = 1;
		
        return view('commissions.index',compact('commissions','page_number'));	
	}

	public function commission_edit($commission_id)
    {
		access_denied_user('commission_edit');
        $commission = Commission::where('id',$commission_id)->first();
		
		if($commission){
			$view = view("modal.commissionEdit",compact('commission'))->render();
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

    /*Update Certificate*/
    public function update_commission($commission_id,Request $request){

    	access_denied_user('commission_edit');

    	$data = [];
    	$data['success'] = false;
    	$data['message'] = 'Invalid Request';
    	if(!empty($commission_id) && isset($request->percentage)){
    		$sno = isset($request->sno) ? $request->sno : 1;
    		$page_number = isset($request->page_number) ? $request->page_number : 0;
    		$commission = Commission::find($commission_id);
    		$updateComm = $commission->update(['percentage'=>$request->percentage]);
    		if($updateComm == true){
    			$data['success'] = true;
    			$data['message'] = 'Successfully Update Certificate Status';
    			$data['view'] = view("commissions.commissionSingleRow",compact('commission','sno','page_number'))->render();
    			$data['class'] = 'user_row_'.$commission->id;
    		}else{
    			$data['message'] = 'Something went wrong, please try later';
    		}
    	}
    	return Response::json($data, 200);
    	
    }
}
