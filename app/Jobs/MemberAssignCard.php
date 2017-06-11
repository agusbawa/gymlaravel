<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Member;
use App\Card;

class MemberAssignCard implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $member;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member   =   $member;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Process Asign New Card
        $memberCard     =   $this->member->card;
        if(count($memberCard)>0)
        {
            return;
        }

        $availableCard  =  Card::whereHas('member',function($query){},0)->first();
        if($availableCard==null)
        {
            return;
        }

        $this->member->card()->attach($availableCard->id);
    }
}
