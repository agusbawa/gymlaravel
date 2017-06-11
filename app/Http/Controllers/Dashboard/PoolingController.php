<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vote;
use App\VoteItem;
use App\MemberVote;
use Auth;
class PoolingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('32',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Vote::bootIndexPage($request->get('keyword'), ['title'],['title'=>'asc']);
        return view('dashboard.pooling.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pooling.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        \Validator::make($request->all(),[
            'title'             =>'required',
            'description'              =>'required',
            'enableregister'             =>'required'
        ])->setAttributeNames([
            'title'             =>'Judul',
            'description'              =>'Description',
            'enableregister'             =>'Tampilkan Pada Register Member'
        ])->validate();

        $vote                  =   new Vote;
        $vote->title           =   $request->get('title');
        $vote->description            =   $request->get('description');
        $vote->enableregister      =   $request->get('enableregister',0);
        $vote->save();
        
        $item = $request->get('item');
        if(count($item) > 0){
            foreach($item as $it){
                if(!empty($it)){
                    $voteItem = new VoteItem;
                    $voteItem->vote_id = $vote->id;
                    $voteItem->title = $it;
                    $voteItem->description = $it;
                    $voteItem->save();
                }                
            }
            
        }

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Pooling']));
        return redirect('/u/poolings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $pooling = Vote::findOrFail($id);
        $items = VoteItem::where('vote_id',$pooling->id)->get();
         return view('dashboard.pooling.show')
         ->with('pooling',$pooling)
         ->with('items',$items) 
         ;
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('32',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $vote    =   Vote::findOrFail($id);
        return view('dashboard.pooling.edit')->with('vote',$vote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Validator::make($request->all(),[
            'title'             =>'required',
            'description'              =>'required',
            'enableregister'             =>'required'
        ])->setAttributeNames([
            'title'             =>'Judul',
            'description'              =>'Description',
            'enableregister'             =>'Tampilkan Pada Register Member'
        ])->validate();

        $vote                  =   Vote::findOrFail($id);
        $vote->title           =   $request->get('title');
        $vote->description            =   $request->get('description');
        $vote->enableregister      =   $request->get('enableregister',0);
        $vote->save();
        
        $item_update = $request->get('item_before');
        $itemBefore = $vote->voteItems()->get();
        $keyItem = array();
        foreach($itemBefore as $tim){
            $keyItem[$tim->id] = true;
            if(isset($item_update[$tim->id])){
                $voteItem = VoteItem::findOrFail($tim->id);
                $voteItem->vote_id = $vote->id;
                $voteItem->title = $item_update[$tim->id];
                $voteItem->description = $item_update[$tim->id];
                $voteItem->save();
            }else{
               $voteItemDel    = VoteItem::findOrFail($tim->id);
                $voteItemDel->delete(); 
            }
        }
                
        $item = $request->get('item');
        if(count($item) > 0){
            foreach($item as $it){
                if(!empty($it)){
                    $voteItem = new VoteItem;
                    $voteItem->vote_id = $vote->id;
                    $voteItem->title = $it;
                    $voteItem->description = $it;
                    $voteItem->save();
                }                
            }
            
        }
        
        

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Pooling']));
        return redirect('/u/poolings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(\App\Permission::DeletePer('32',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $item = VoteItem::where('vote_id',$id)->get();
        
        foreach($item as $vote){
            $membervote = MemberVote::where('vote_item_id',$vote->id)->get();
            foreach($membervote as $member){
                MemberVote::find($member->id)->delete();
            }
            VoteItem::findOrFail($vote->id)->first()->delete();
        }
        Vote::findOrFail($id)->delete();
        request()->session()->flash('alert-success', 'Polling berhasil dihapus');
        return redirect('/u/poolings');
    }
}
