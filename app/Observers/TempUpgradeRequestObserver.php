<?php

namespace App\Observers;

use App\Models\TempUpgradeRequest;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserPayment;
use Carbon\Carbon;

class TempUpgradeRequestObserver
{
    /**
     * Handle the temp upgrade request "created" event.
     *
     * @param  \App\Models\TempUpgradeRequest  $tempUpgradeRequest
     * @return void
     */
    public function created(TempUpgradeRequest $tempUpgradeRequest)
    {
        if(!empty($tempUpgradeRequest) && !empty($tempUpgradeRequest->user_id)){
            /*Check if status paid i.e status 1, then change user plan id and locking period*/
            if($tempUpgradeRequest->status == 1){
                $selectedPlan = $tempUpgradeRequest->plan_id;
                $lockingPeriod = $this->fetchPlanLockingPeriod($selectedPlan);

                $lockingPeriodStart = Carbon::parse($tempUpgradeRequest->created_at)->format('Y-m-d');
                $lockingPeriodEnd = Carbon::parse($tempUpgradeRequest->created_at)->addMonths($lockingPeriod)->format('Y-m-d');

                $userInfo = [];
                $userInfo['user_id'] = $tempUpgradeRequest->user_id;
                $userInfo['plan_id'] = $tempUpgradeRequest->plan_id;
                $userInfo['lockingPeriodStart'] = $lockingPeriodStart;
                $userInfo['lockingPeriodEnd'] = $lockingPeriodEnd;
                $updateUserInfo = $this->updateUser($userInfo);

                //when we update user plan at same time go entry for payment in user payment table
                $userPaymentData = [];
                $userPaymentData['user_id'] = $tempUpgradeRequest->user_id;
                $userPaymentData['plan_id'] = $tempUpgradeRequest->plan_id;
                $userPaymentData['amount'] = $tempUpgradeRequest->amount;
                UserPayment::create($userPaymentData);
            }
        }
    }

    /**
     * Handle the temp upgrade request "updated" event.
     *
     * @param  \App\Models\TempUpgradeRequest  $tempUpgradeRequest
     * @return void
     */
    public function updated(TempUpgradeRequest $tempUpgradeRequest)
    {
        if(!empty($tempUpgradeRequest) && !empty($tempUpgradeRequest->user_id)){
            /*Check if status paid i.e status 1, then change user plan id and locking period*/
            if($tempUpgradeRequest->status == 1){
                $selectedPlan = $tempUpgradeRequest->plan_id;
                $lockingPeriod = $this->fetchPlanLockingPeriod($selectedPlan);

                $lockingPeriodStart = Carbon::parse($tempUpgradeRequest->created_at)->format('Y-m-d');
                $lockingPeriodEnd = Carbon::parse($tempUpgradeRequest->created_at)->addMonths($lockingPeriod)->format('Y-m-d');

                $userInfo = [];
                $userInfo['user_id'] = $tempUpgradeRequest->user_id;
                $userInfo['plan_id'] = $tempUpgradeRequest->plan_id;
                $userInfo['lockingPeriodStart'] = $lockingPeriodStart;
                $userInfo['lockingPeriodEnd'] = $lockingPeriodEnd;
                $updateUserInfo = $this->updateUser($userInfo);

                //when we update user plan at same time go entry for payment in user payment table
                $userPaymentData = [];
                $userPaymentData['user_id'] = $tempUpgradeRequest->user_id;
                $userPaymentData['plan_id'] = $tempUpgradeRequest->plan_id;
                $userPaymentData['amount'] = $tempUpgradeRequest->amount;
                UserPayment::create($userPaymentData);
            }
        }
    }

    /**
     * Handle the temp upgrade request "deleted" event.
     *
     * @param  \App\Models\TempUpgradeRequest  $tempUpgradeRequest
     * @return void
     */
    public function deleted(TempUpgradeRequest $tempUpgradeRequest)
    {
        //
    }

    /**
     * Handle the temp upgrade request "restored" event.
     *
     * @param  \App\Models\TempUpgradeRequest  $tempUpgradeRequest
     * @return void
     */
    public function restored(TempUpgradeRequest $tempUpgradeRequest)
    {
        //
    }

    /**
     * Handle the temp upgrade request "force deleted" event.
     *
     * @param  \App\Models\TempUpgradeRequest  $tempUpgradeRequest
     * @return void
     */
    public function forceDeleted(TempUpgradeRequest $tempUpgradeRequest)
    {
        //
    }

    /*fetch plan related info*/
    public function fetchPlanLockingPeriod($plan_id){
        $selectedPlanInfo = Plan::where('id',$plan_id)->first();
        $lockingPeriod = 0;
        if(!is_null($selectedPlanInfo) && ($selectedPlanInfo->count())>0){
            $lockingPeriod = $selectedPlanInfo->locking_period;
        }
        return $lockingPeriod;

    }

    /*update User Table*/
    public function updateUser($data){
        $user = User::find($data['user_id']);

        if ($user) {
            $user->update([
                'plan_id' => $data['plan_id'],
                'locking_period_start'  => $data['lockingPeriodStart'],
                'locking_period_end' => $data['lockingPeriodEnd']
            ]);
        }
    }
}
