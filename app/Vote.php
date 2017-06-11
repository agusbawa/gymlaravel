<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\RegymEloquentTrait;

class Vote extends Model {
	use RegymEloquentTrait;

	protected $table = 'votes';
	public $timestamps = true;

	public function voteItems()
	{
		return $this->hasMany('App\VoteItem');
	}
        
        public function getVoteItems($memberId){
            $vt = $this->voteItems;
            
            $return = true;
            
            foreach($vt as $item){
                $d = MemberVote::where(['vote_item_id' => $item->id, 'member_id' => $memberId ])->first();
                if(!is_null($d)){
                    return false;
                }
            }
            
            return $return;
        }
        

}