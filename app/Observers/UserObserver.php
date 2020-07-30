<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserReferral;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        /*After new user registration, check who refer him, and save that entry in user referral table*/
        if(!empty($user) && !empty($user->refered_by)){
            $new_user_id = $user->id;
            /*find which refer him*/
            $referUser = User::where('mobile_number',$user->refered_by)->orWhere('aadhar_number',$user->refered_by)->where('id','!=',$new_user_id)->first();
            if(!is_null($referUser)){
                $ref_user_id1 = $referUser->id;

                //check who refer referral user 1
                $ref_users = UserReferral::where('user_id',$ref_user_id1)->orderBy('id','desc')->first();
                if(!empty($ref_users) && !is_null($ref_users) && ($ref_users->count()) > 0){
                    for($i=2;$i<=5;$i++){
                        $j=$i-1;
                        ${"ref_user_id$i"} = $ref_users["ref_user_id$j"];
                    }
                }else{
                    for($i=2;$i<=5;$i++){
                        ${"ref_user_id$i"} = NULL;
                    }
                }

                UserReferral::create([
                    'user_id' => $new_user_id,
                    'ref_user_id1' => $ref_user_id1,
                    'ref_user_id2' => $ref_user_id2,
                    'ref_user_id3' => $ref_user_id3,
                    'ref_user_id4' => $ref_user_id4,
                    'ref_user_id5' => $ref_user_id5
                ]);
            }
        }
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
