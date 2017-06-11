<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\MemberHistory;
use Carbon\Carbon;
use App\Vote;
use App\VoteItem; 
use App\MemberVote;
class PollingController extends Controller
{
    public function index(Request $request){
        $vote = Vote::get();
        $member = $request->get('member_id');
        $voteArray = array();
        if(!empty($member)){
            $voteArray = array();
            foreach($vote as $v){
                if($v->getVoteItems($member)){
                    $voteArray[] = $v;
                }

            }
        }
        
        
        return Response::json(['vote'=>$voteArray],200);
    }
    
    public function saveData(Request $request){
        
        $vote = new MemberVote();
        $vote->vote_item_id = $request->get('vote_id');
        $vote->member_id = $request->get('member_id');
        $vote->save();
        
        
        return Response::json(['sts' => 'ok'],200);
    }
}