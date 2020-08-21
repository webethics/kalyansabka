<?php

namespace App\Observers;

use App\Models\ClaimIntimation;
use App\Models\ClaimMedia;

class ClaimIntimationObserver
{
    /**
     * Handle the claim intimation "created" event.
     *
     * @param  \App\Models\ClaimIntimation  $claimIntimation
     * @return void
     */
    public function created(ClaimIntimation $claimIntimation)
    {
        //
    }

    /**
     * Handle the claim intimation "updated" event.
     *
     * @param  \App\Models\ClaimIntimation  $claimIntimation
     * @return void
     */
    public function updated(ClaimIntimation $claimIntimation)
    {
        /*Check if request approved then change user status to 2 means close account*/
    }

    /**
     * Handle the claim intimation "deleted" event.
     *
     * @param  \App\Models\ClaimIntimation  $claimIntimation
     * @return void
     */
    public function deleted(ClaimIntimation $claimIntimation)
    {
        /*when claim delete its corresponding media also deleted*/
        if(!empty($claimIntimation) && !empty($claimIntimation->id)){
            $media = ClaimMedia::where('claim_intimation_id',$claimIntimation->id)->delete();
        }
    }

    /**
     * Handle the claim intimation "restored" event.
     *
     * @param  \App\Models\ClaimIntimation  $claimIntimation
     * @return void
     */
    public function restored(ClaimIntimation $claimIntimation)
    {
        //
    }

    /**
     * Handle the claim intimation "force deleted" event.
     *
     * @param  \App\Models\ClaimIntimation  $claimIntimation
     * @return void
     */
    public function forceDeleted(ClaimIntimation $claimIntimation)
    {
        //
    }
}
