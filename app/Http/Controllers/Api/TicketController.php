<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use Carbon\Carbon;
use App\TiketSupport;
use App\TiketMessage;
class TicketController extends Controller
{
    public function create(Request $request){
        $r = new TiketSupport();
        $r->status = 'New';
        $r->title = $request->get('title');
        $r->member_id = $request->get('member_id');
        $r->save();
        
        $d = new TiketMessage();
        $d->pesan = $request->get('pesan');
        $d->tiket_id = $r->id;
        $d->author = 1;
        $d->save();
        return Response::json(['sts' => 'ok'],200);
    }
    
    public function replay(Request $request){
        $data = new TiketMessage;
        $data->pesan = $request->get('pesan');
        $data->tiket_id = $request->get('ticket_id');
        $data->author = 1;
        $data->save();
        $support = TiketSupport::findOrFail($request->get('ticket_id'));
        $support->status = "New";
        $support->save();
        return Response::json(['sts' => 'ok'],200);
    }
    
    public function detailticket(Request $request){
        $tiketsupport = TiketSupport::findOrFail($request->get('ticket_id'));
        if($tiketsupport){
            $messages = TiketMessage::where('tiket_id',$tiketsupport->id)->orderBy('created_at','ASC')->get();
            return Response::json(['sts' => 'ok','general'=>$tiketsupport,'msg'=>$messages],200);
        }else{
            return Response::json(['sts' => 'error'],200);
        }
//        return Response::json(['sts' => $request->get('ticket_id')],200);
    }
    public function listticket(Request $request){
        $data = TiketSupport::where('member_id',$request->get('member_id'))->get();
        return Response::json(['sts' => 'ok', 'list' => $data],200);
    }
    
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