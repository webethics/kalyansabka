<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeHistory;
use App\Models\Commission;
use App\Models\User;
use App\Models\Role;
use App\Models\StateHeads;
use App\Models\DistrictHeads;

class CommanController extends Controller
{
	/*function that distribute head commission sabed on user plan_id*/
    public static function distributeHeadCommissions($user_id){
    	if(!empty($user_id)){
    		//fetch commissions
            $commission = Commission::get();
            foreach ($commission as $key => $com) {
                $name = $com['slug'];
                ${"$name"} = $com['percentage'];
            }

            /*Get new user policy info*/
            $userData = User::with('plan')->where('id',$user_id)->first();
            if(!is_null($userData) && ($userData->count()) >0){
                $state_id = $userData->state_id;
                $district_id = $userData->district_id;
                //fetch plan info
                if(!is_null($userData->plan) && ($userData->plan->count())>0){
                    $planData = $userData->plan;
                    $planCost = $planData->cost;

	                //Full distribute commission
	                $full_distribute_commission = CommanController::calculatePercentageAmount($planCost,$referred_user_commission);
	                //head distribute commission from full distribute commission
	                $head_distribute_commission = CommanController::calculatePercentageAmount($full_distribute_commission,$heads_commission);
	                //Remaining distribute commission between individual referral
	                $level_user_commission = $full_distribute_commission - $head_distribute_commission;

	                /*Send commission to all head*/

	                $indiaHeadRole = Role::where('slug','india-head')->first();
	                $indiaHeadUserId = NULL;

	                if(!is_null($indiaHeadRole) && ($indiaHeadRole->count())>0){
	                    $role_india_head = $indiaHeadRole->id;
	                    //fetch head user
	                    if(isset($role_india_head) && !empty($role_india_head)){
	                        $userIndiaHead = User::where('role_id',$role_india_head)->first();
	                        if(!is_null($userIndiaHead)){
	                            $indiaHeadUserId = $userIndiaHead->id;
	                            //send commission
	                            $indiaHeadComm = CommanController::calculatePercentageAmount($head_distribute_commission,$india_head);

	                            $dataRef = [];
	                            $dataRef['user_id'] = $indiaHeadUserId;
	                            if(isset($userReferral) && !empty($userReferral))
	                            	$dataRef['referral_id'] = $userReferral['user_id'];
	                            else
	                            	$dataRef['referral_id'] = NULL;
	                            $dataRef['amount'] = $indiaHeadComm;
	                            $dataRef['comment'] = 'New user Register';
	                            CommanController::saveIncomeHistory($dataRef);
	                        }
	                    }
	                }

	                //get state head
	                if(isset($state_id) && !empty($state_id)){
	                    $stateUser = StateHeads::where('state_id',$state_id)->orderBy('id','desc')->first();

	                    //calculate state commission
	                    $stateComm = CommanController::calculatePercentageAmount($head_distribute_commission,$state_head);

	                    if(!is_null($stateUser)){
	                        //send commission
	                        $dataRef = [];
	                        $dataRef['user_id'] = $stateUser->user_id;
	                        if(isset($userReferral) && !empty($userReferral))
	                        	$dataRef['referral_id'] = $userReferral['user_id'];
	                        else
	                            $dataRef['referral_id'] = NULL;
	                        $dataRef['amount'] = $stateComm;
	                        $dataRef['comment'] = 'New user Register';
	                        CommanController::saveIncomeHistory($dataRef);
	                        
	                    }else{
	                        //send commission to Indian head, if state head not there
	                        if(!is_null($indiaHeadUserId) && !empty($indiaHeadUserId)){

	                            $dataRef = [];
	                            $dataRef['user_id'] = $indiaHeadUserId;
	                            if(isset($userReferral) && !empty($userReferral))
	                            	$dataRef['referral_id'] = $userReferral['user_id'];
	                            else
	                            	$dataRef['referral_id'] = NULL;
	                            $dataRef['amount'] = $stateComm;
	                            $dataRef['comment'] = 'New user Register';
	                            CommanController::saveIncomeHistory($dataRef);
	                        }
	                        
	                    }
	                }

	                //get district head
	                if(isset($district_id) && !empty($district_id)){
	                    $districtUser = DistrictHeads::where('district_id',$district_id)->orderBy('id','desc')->first();

	                    //calculate district comm
	                    $distictComm = CommanController::calculatePercentageAmount($head_distribute_commission,$district_head);

	                    if(!is_null($districtUser)){
	                        //send commission
	                        $dataRef = [];
	                        $dataRef['user_id'] = $districtUser->user_id;
	                        if(isset($userReferral) && !empty($userReferral))
	                        	$dataRef['referral_id'] = $userReferral['user_id'];
	                        else
	                            $dataRef['referral_id'] = NULL;
	                        $dataRef['amount'] = $distictComm;
	                        $dataRef['comment'] = 'New user Register';
	                        CommanController::saveIncomeHistory($dataRef);
	                        
	                    }else{
	                        //send commission to Indian head, if district head not there
	                        if(!is_null($indiaHeadUserId) && !empty($indiaHeadUserId)){

	                            $dataRef = [];
	                            $dataRef['user_id'] = $indiaHeadUserId;
	                            if(isset($userReferral) && !empty($userReferral))
	                            	$dataRef['referral_id'] = $userReferral['user_id'];
	                            else
	                            	$dataRef['referral_id'] = NULL;
	                            $dataRef['amount'] = $distictComm;
	                            $dataRef['comment'] = 'New user Register';
	                            CommanController::saveIncomeHistory($dataRef);
	                        }

	                    }
	                }
	            }
            }

    	}

    }

    /*Calculate percentage amount*/
    public static function calculatePercentageAmount($cost,$percentage){
        $amount = 0;
        if(!empty($cost) && !empty($percentage)){
            $amount = number_format((($cost * $percentage)/100),2,'.', '');
        }
        return $amount;
    }

    /*save data to income History table*/
    public static function saveIncomeHistory($data){
    	$generated_trasaction_id = getToken(9);
        if(!empty($data)){
            IncomeHistory::create([
                'user_id' => $data['user_id'],
                'referral_id' => $data['referral_id'],
                'mode' => 1,
                'status' => 1,
                'transaction_id' => $generated_trasaction_id,
                'amount' => $data['amount'],
                'comment' => $data['comment'],
            ]);
        }
        return 1;
    }
}
