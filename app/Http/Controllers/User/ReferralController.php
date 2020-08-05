<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserReferral;
use App\Models\User;
use Config;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
    	if($request->ajax()){
    		$response = [];
    		$data = $request->all();
    		$user_id = $data['member_id'];
    		$userData = User::where('id',$user_id)->first();

    		$response['status'] = Config::get('constant.ERROR');
        	$response['msg'] = 'Something went wrong,please try later!!';
    	}else{
    		$user_id = user_id();
    		$userData = user_data();
    	}
    	$memberInfo = [];$member_counter = 0; $userInfo = [];
    	$level1 = []; $level1_counter = 0; $level2 = []; $level3 = [];

    	/*check if user id not empty*/
    	if(!empty($user_id)){
	    	
	    	/*fetch how many level of tree created*/
	    	$tree_level = Config::get('constant.TREE_LEVEL');
	    	if(empty($tree_level) || intval($tree_level) == 0)
	    		$tree_level = 2;

	    	$userInfo['user_id'] = $user_id;
	    	$userInfo['email'] = $userData->email;

	    	$memberInfo[$member_counter]['memberId'] = $user_id;
	    	$memberInfo[$member_counter]['parentId'] = null;
	    	$memberInfo[$member_counter]['counter'] = $userData->referral_count;
	    	$memberInfo[$member_counter]['name'] = ucfirst("{$userData->first_name} {$userData->last_name}");;
	    	$memberInfo[$member_counter]['email'] = $userData->email;
	    	$memberInfo[$member_counter]['level'] = 0;

	    	/*$userReferral = UserReferral::with('user')->where('ref_user_id1',$user_id)->orWhere('ref_user_id2',$user_id)->orWhere('ref_user_id3',$user_id)->get();*/
	    	$userReferral = UserReferral::with('user');
	    	/*Get all user referral 1 to tree level*/
            for($i=1;$i<=intval($tree_level);$i++){
            	$userReferral = $userReferral->orWhere("ref_user_id$i",$user_id);
	    	}

	    	$userReferral = $userReferral->get();


	    	if($userReferral && count($userReferral) > 0){
	    		foreach($userReferral as $key => $ref) {
	    			$member_counter++;
	    			//checl is level 1 then push into level1 array
		    		if($ref['ref_user_id1'] == $user_id){
		    			$level = 1;
		    			$level1[$level1_counter]['user_id'] = $ref['user_id'];
		    			$level1[$level1_counter]['email'] = $ref->user['email'];
		    			$level1_counter++;
		    		}
		    		if($ref['ref_user_id2'] == $user_id){
		    			$level = 2;
		    			//check if ref_user1 key exist
		    			$level2_counter = 0;
		    			if (array_key_exists($ref['ref_user_id1'],$level2)){
		    				$level2_counter = count($level2[$ref['ref_user_id1']]);
		    			}
		    			$level2[$ref['ref_user_id1']][$level2_counter]['user_id'] = $ref['user_id'];
		    			$level2[$ref['ref_user_id1']][$level2_counter]['email'] = $ref->user['email'];
		    		}

		    		$memberInfo[$member_counter]['memberId'] = $ref['user_id'];
			    	$memberInfo[$member_counter]['parentId'] = $ref['ref_user_id1'];
			    	$memberInfo[$member_counter]['counter'] = $ref->user['referral_count'];
			    	$memberInfo[$member_counter]['name'] = ucfirst("{$ref->user['first_name']} {$ref->user['last_name']}");
			    	$memberInfo[$member_counter]['email'] = $ref->user['email'];
			    	$memberInfo[$member_counter]['level'] = $level;
		    	}
	    	}

	    	/*echo '<pre>'; print_r($level1); echo '</pre>';
	    	dd($level2);*/
	    	$response['status'] = Config::get('constant.SUCCESS');
	        $response['msg'] = trans('message.AJAX_SUCCESS');

	    }

    	if($request->ajax()){
    		$response['memberInfo'] = $memberInfo;
    		$response['userInfo'] = $userInfo;

    		return $response;
    	}else{
    		return view('referrals.index',compact('userInfo','memberInfo'));
    	}
    	
    }
}
?>