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
    	$level1 = []; $level_counter1 = 0;

    	/*check if user id not empty*/
    	if(!empty($user_id)){
	    	
	    	/*fetch how many level of tree created*/
	    	$tree_level = Config::get('constant.TREE_LEVEL');
	    	if(empty($tree_level) || intval($tree_level) == 0)
	    		$tree_level = 2;

	    	for($i=2;$i<=$tree_level;$i++){
	    		${"level$i"} = [];
	    	}

	    	$userInfo['user_id'] = $user_id;
	    	$userInfo['email'] = $userData->email;
	    	$userInfo['name'] = ucfirst("{$userData->first_name} {$userData->last_name}");
	    	$userInfo['counter'] = $userData->referral_count;
	    	$userInfo['level'] = 0;

	    	$memberInfo[$member_counter]['memberId'] = $user_id;
	    	$memberInfo[$member_counter]['parentId'] = null;
	    	$memberInfo[$member_counter]['counter'] = $userData->referral_count;
	    	$memberInfo[$member_counter]['name'] = ucfirst("{$userData->first_name} {$userData->last_name}");
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
		    			$level1[$level_counter1]['user_id'] = $ref['user_id'];
		    			$level1[$level_counter1]['email'] = $ref->user['email'];
		    			$level1[$level_counter1]['name'] = ucfirst("{$ref->user['first_name']} {$ref->user['last_name']}");
		    			$level1[$level_counter1]['parentId'] = $ref['ref_user_id1'];
		    			$level1[$level_counter1]['counter'] = $ref->user['referral_count'];
		    			$level1[$level_counter1]['level'] = $level;

		    			$level_counter1++;
		    		}

		    		for($j=2;$j<=$tree_level;$j++){
		    			if($ref["ref_user_id$j"] == $user_id){
			    			$level = $j;
			    			//check if ref_user1 key exist
			    			${"level_counter$j"} = 0;
			    			$k = $j-1;
			    			if (array_key_exists($ref["ref_user_id$k"],${"level$j"})){
			    				${"level_counter$j"} = count(${"level$j"}[$ref["ref_user_id$k"]]);
			    			}
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['user_id'] = $ref['user_id'];
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['email'] = $ref->user['email'];
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['name'] = ucfirst("{$ref->user['first_name']} {$ref->user['last_name']}");
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['parentId'] = $ref['ref_user_id1'];
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['counter'] = $ref->user['referral_count'];
			    			${"level$j"}[$ref["ref_user_id1"]][${"level_counter$j"}]['level'] = $level;
			    			break;
			    		}
		    		}
		    		

		    		$memberInfo[$member_counter]['memberId'] = $ref['user_id'];
			    	$memberInfo[$member_counter]['parentId'] = $ref['ref_user_id1'];
			    	$memberInfo[$member_counter]['counter'] = $ref->user['referral_count'];
			    	$memberInfo[$member_counter]['name'] = ucfirst("{$ref->user['first_name']} {$ref->user['last_name']}");
			    	$memberInfo[$member_counter]['email'] = $ref->user['email'];
			    	$memberInfo[$member_counter]['level'] = $level;
		    	}
	    	}

	    	$level = [];
	    	for($l=1;$l<=$tree_level;$l++) {
	    		$level["level$l"] = ${"level$l"};
	    	}

	    	$response['status'] = Config::get('constant.SUCCESS');
	        $response['msg'] = trans('message.AJAX_SUCCESS');

	    }

    	if($request->ajax()){
    		$response['memberInfo'] = $memberInfo;
    		$response['userInfo'] = $userInfo;
    		$response['level'] = $level;

    		return $response;
    	}else{
    		//return view('referrals.index',compact('userInfo','memberInfo','level'));
    		return view('referrals.structure',compact('userInfo','memberInfo','level','tree_level'));
    	}
    	
    }
}
?>