<?php

namespace App\Observers;

use App\Models\CancelPolicyRequest;
use App\Models\User;

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

            $updateUserInfo = $this->updateHideCancelButton($cancelPolicyRequest);
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
                'show_cancellation_status' => 1,
            ]);
        }
    }

    /*update User Table*/
    public function updateUser($data){
        $user = User::find($data['user_id']);

        if ($user) {
            $user->update([
                'show_cancellation_status' => 1,
                'plan_id' => 0
            ]);
        }
    }
}
