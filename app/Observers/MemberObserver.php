<?php

namespace App\Observers;

use App\Member;

class MemberObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(Member $member)
    {
        $options                    =   new \App\MemberOption;
        $options->member_id         =   $member->id;
        $options->last_reminder_at  =   \Carbon\Carbon::now();
        $options->save();

        // Send Email For Password & Thankyou information
        //$member->notify(new \App\Notifications\MemberCreated());
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(Member $member)
    {
        // $member->options->delete();
    }
}