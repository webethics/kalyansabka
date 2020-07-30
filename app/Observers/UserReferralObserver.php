<?php

namespace App\Observers;

use App\Models\UserReferral;
use App\Models\IncomeHistory;
use App\Models\Commission;
use App\Models\User;
use App\Models\Role;
use App\Models\StateHeads;
use App\Models\DistrictHeads;

class UserReferralObserver
{
    /**
     * Handle the user referral "created" event.
     *
     * @param  \App\Models\UserReferral  $userReferral
     * @return void
     */
    public function created(UserReferral $userReferral)
    {
        if(!empty($userReferral) && !empty($userReferral->ref_user_id1)){
            //fetch commissions
            $commission = Commission::get();
            foreach ($commission as $key => $com) {
                $name = $com['slug'];
                ${"$name"} = $com['percentage'];
            }

            /*Get new user policy info*/
            $userData = User::with('plan')->where('id',$userReferral->user_id)->first();
            if(!is_null($userData) && ($userData->count()) >0){
                $state_id = $userData->state_id;
                $district_id = $userData->district_id;
                //fetch plan info
                if(!is_null($userData->plan) && ($userData->plan->count())>0){
                    $planData = $userData->plan;
                    $planCost = $planData->cost;

                    //Full distribute commission
                    $full_distribute_commission = $this->calculatePercentageAmount($planCost,$referred_user_commission);
                    //head distribute commission from full distribute commission
                    $head_distribute_commission = $this->calculatePercentageAmount($full_distribute_commission,$heads_commission);
                    //Remaining distribute commission between individual referral
                    $level_user_commission = $full_distribute_commission - $head_distribute_commission;

                    /*Get all user referral 1 to 5 and deposite income to him according to level*/
                    for($i=1;$i<=5;$i++){
                        ${"ref_user_id$i"} = $userReferral["ref_user_id$i"];
                        if(isset(${"ref_user_id$i"}) && !empty(${"ref_user_id$i"})){
                            $distribute_amount = $this->calculatePercentageAmount($level_user_commission,$individual_user_commission);
                            //insert entry in income history table
                            IncomeHistory::create([
                                'user_id' => ${"ref_user_id$i"},
                                'referral_id' => $userReferral['user_id'],
                                'mode' => 1,
                                'amount' => $distribute_amount,
                                'comment' => 'Referral new user',
                            ]);
                            //update referral count on user table
                            User::find(${"ref_user_id$i"})->increment('referral_count');
                            //Modify level commission for next level
                            $level_user_commission = $distribute_amount;
                        }else{
                            /*No refer exist, break loop*/
                            break;
                        }
                    }

                    /*Send commission to all head*/

                    //find Indian head
                    /*$roles = Role::get();

                    if(!is_null($roles) && ($roles->count()) >0){
                        foreach ($roles as $key => $role) {
                            $name = $role['slug'];
                            $name = strtolower(str_replace("-","_",$name)); 
                            ${"role_$name"} = $role['id'];
                        }*/
                    $indiaHeadRole = Role::where('slug','india-head')->first();

                    if(!is_null($indiaHeadRole) && ($indiaHeadRole->count())>0){
                        $role_india_head = $indiaHeadRole->id;
                        //fetch head user
                        if(isset($role_india_head) && !empty($role_india_head)){
                            $userIndiaHead = User::where('role_id',$role_india_head)->first();
                            if(!is_null($userIndiaHead)){
                                $indiaHeadUserId = $userIndiaHead->id;
                                //send commission
                                $indiaHeadComm = $this->calculatePercentageAmount($head_distribute_commission,$india_head);

                                IncomeHistory::create([
                                    'user_id' => $indiaHeadUserId,
                                    'referral_id' => $userReferral['user_id'],
                                    'mode' => 1,
                                    'amount' => $indiaHeadComm,
                                    'comment' => 'Referral new user',
                                ]);
                            }
                        }
                    }

                    //get state head
                    if(isset($state_id) && !empty($state_id)){
                        $stateUser = StateHeads::where('state_id',$state_id)->orderBy('id','desc')->first();

                        if(!is_null($stateUser)){
                            //send commission
                            $stateComm = $this->calculatePercentageAmount($head_distribute_commission,$state_head);

                            IncomeHistory::create([
                                'user_id' => $stateUser->id,
                                'referral_id' => $userReferral['user_id'],
                                'mode' => 1,
                                'amount' => $stateComm,
                                'comment' => 'Referral new user',
                            ]);
                        }
                    }

                    //get district head
                    if(isset($district_id) && !empty($district_id)){
                        $districtUser = DistrictHeads::where('district_id',$district_id)->orderBy('id','desc')->first();

                        if(!is_null($districtUser)){
                            //send commission
                            $distictComm = $this->calculatePercentageAmount($head_distribute_commission,$district_head);

                            IncomeHistory::create([
                                'user_id' => $districtUser->id,
                                'referral_id' => $userReferral['user_id'],
                                'mode' => 1,
                                'amount' => $distictComm,
                                'comment' => 'Referral new user',
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Handle the user referral "updated" event.
     *
     * @param  \App\Models\UserReferral  $userReferral
     * @return void
     */
    public function updated(UserReferral $userReferral)
    {
        //
    }

    /**
     * Handle the user referral "deleted" event.
     *
     * @param  \App\Models\UserReferral  $userReferral
     * @return void
     */
    public function deleted(UserReferral $userReferral)
    {
        //
    }

    /**
     * Handle the user referral "restored" event.
     *
     * @param  \App\Models\UserReferral  $userReferral
     * @return void
     */
    public function restored(UserReferral $userReferral)
    {
        //
    }

    /**
     * Handle the user referral "force deleted" event.
     *
     * @param  \App\Models\UserReferral  $userReferral
     * @return void
     */
    public function forceDeleted(UserReferral $userReferral)
    {
        //
    }

    /*Calculate percentage amount*/
    public function calculatePercentageAmount($cost,$percentage){
        $amount = 0;
        if(!empty($cost) && !empty($percentage)){
            $amount = number_format((($cost * $percentage)/100),2,'.', '');
        }
        return $amount;
    }

    /*save data to income History table*/
    public function saveIncomeHistory($data){
        if(!empty($data)){
            IncomeHistory::create([
                'user_id' => $data['user_id'],
                'referral_id' => $data['referral_id'],
                'mode' => $data['mode'],
                'amount' => $data['amount'],
                'comment' => 'Referral new user',
            ]);
        }
        return 1;
    }
}
