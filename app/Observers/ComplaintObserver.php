<?php

namespace App\Observers;

use App\Models\Complaints;
use App\Models\Reply;

class ComplaintObserver
{
    /**
     * Handle the complaint "created" event.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return void
     */
    public function created(Complaints $complaint)
    {
        //
    }

    /**
     * Handle the complaint "updated" event.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return void
     */
    public function updated(Complaints $complaint)
    {
        //
    }

    /**
     * Handle the complaint "deleted" event.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return void
     */
    public function deleted(Complaints $complaint)
    {
        /*when complain delete its corresponding replies also deleted*/
        if(!empty($complaint) && !empty($complaint->id)){
            $replies = Reply::where('complaint_id',$complaint->id)->delete();
        }
    }

    /**
     * Handle the complaint "restored" event.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return void
     */
    public function restored(Complaints $complaint)
    {
        //
    }

    /**
     * Handle the complaint "force deleted" event.
     *
     * @param  \App\Models\Complaint  $complaint
     * @return void
     */
    public function forceDeleted(Complaints $complaint)
    {
        //
    }
}
