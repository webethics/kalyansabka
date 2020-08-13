<?php

namespace App\Observers;

use App\Models\CancelPolicyRequest;
use App\Models\User;
use Carbon\Carbon;

class CancelPolicyRequestObserver
{
    /**
     * Handle the cancel policy request "created" event.
     *
     * @param  \App\Models\CancelPolicyRequest  $cancelPolicyRequest
     * @return void
     */
    public function created(CancelPolicyRequest $cancelPolicyRequest)
    {
        if(!empty($cancelPolicyRequest) && !empty($cancelPolicyRequest->user_id)){
            $data = [];
            $data['user_id'] = $cancelPolicyRequest->user_id;
            $data['show_cancellation_status'] = 1;
            $updateUserInfo = $this->updateHideCancelButton($data);
        }
    }

    /**
     * Handle the cancel policy request "updated" event.
     *
     * @param  \App\Models\CancelPolicyRequest  $cancelPolicyRequest
     * @return void
     */
    public function updated(CancelPolicyRequest $cancelPolicyRequest)
    {
        if(!empty($cancelPolicyRequest) && !empty($cancelPolicyRequest->user_id)){
            //Approve cancel request
            if ($cancelPolicyRequest->request_status == 2) {
               $updateUserInfo = $this->updateUser($cancelPolicyRequest);
            }elseif($cancelPolicyRequest->request_status == 1) {
                /*Decline Cancel request*/
                $updateCancelInfo = $this->updateCancelPolicyStatus($cancelPolicyRequest);
            }
        }
    }

    /**
     * Handle the cancel policy request "deleted" event.
     *
     * @param  \App\Models\CancelPolicyRequest  $cancelPolicyRequest
     * @return void
     */
    public function deleted(CancelPolicyRequest $cancelPolicyRequest)
    {
        //
    }

    /**
     * Handle the cancel policy request "restored" event.
     *
     * @param  \App\Models\CancelPolicyRequest  $cancelPolicyRequest
     * @return void
     */
    public function restored(CancelPolicyRequest $cancelPolicyRequest)
    {
        //
    }

    /**
     * Handle the cancel policy request "force deleted" event.
     *
     * @param  \App\Models\CancelPolicyRequest  $cancelPolicyRequest
     * @return void
     */
    public function forceDeleted(CancelPolicyRequest $cancelPolicyRequest)
    {
        //
    }

    /*update User Table*/
    public function updateHideCancelButton($data){
        $user = User::find($data['user_id']);
        if ($user) {
            $user->update([
                'show_cancellation_status' => $data['show_cancellation_status'],
            ]);
        }
    }

    /*update User Table*/
    public function updateUser($data){
        $user = User::find($data['user_id']);
        if ($user) {
            $user->update([
                'plan_id' => 0
            ]);
        }
    }

    /*If admin decline request, then first check if user register is less than 15 days or not upgrade his request till now then show cancel policy button to user*/
    public function updateCancelPolicyStatus($data){
        $user = User::with('tempUpgradeRequest')->where('id',$data['user_id'])->first();
        if ($user) {
            $date = Carbon::parse($user->created_at);
            $now = Carbon::now();

            $diff = $date->diffInDays($now);
            if($diff <= 15){
                //check if user not upgrade plan request
                $upgradeRequest = $user->tempUpgradeRequest;
                //if there s no upgrade request
                if($upgradeRequest->count() == 0){
                    $dataInfo = [];
                    $dataInfo['user_id'] = $data['user_id'];
                    $dataInfo['show_cancellation_status'] = 0;
                    $updateUserInfo = $this->updateHideCancelButton($dataInfo);
                }
            }
        }

    }
}
