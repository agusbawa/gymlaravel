<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Gym;
use Carbon\Carbon;
class GymInfoController extends Controller
{
    //
    public function index(){
    	return Response::json(['text'=>'hai'],200);
    }
    public function oldmember($id){
        $data = Member::where('slug',$id)->first();
        return Response::json(['text'=>$data],200);
    }
    public function listdata(){
        $data = Gym::all();
        return Response::json(['list'=>$data],200);
    }
    
}
