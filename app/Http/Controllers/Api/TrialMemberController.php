<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Trialmember;
use App\Mail\freeTrial;
use Carbon\Carbon;
class TrialMemberController extends Controller
{
    //
    public function index(){
    	return Response::json(['text'=>'hai'],200);
    }
    
    
    public function register(Request $request){
        $trialmember                  =   new Trialmember;
        $trialmember->name           =   $request->get('name');
        $trialmember->nick_name            =   $request->get('nick_name');
        $trialmember->address_street            =   $request->get('address_street');
        $trialmember->address_region            =   $request->get('address_region');
        $trialmember->address_city            =   $request->get('address_city');
        $trialmember->place_of_birth            =   $request->get('place_of_birth');
        $trialmember->date_of_birth            =   date('Y-m-d',strtotime($request->get('date_of_birth')));
        $trialmember->gender            =   $request->get('gender');
        $trialmember->phone            =   $request->get('phone');
        $trialmember->gym_id            =   $request->get('gym_id');
        $trialmember->email               = $request->get('email');
        $trialmember->save();
        
         Mail::to($trialmember->email)->send(new freeTrial ($trialmember->email));
        return Response::json(['sts'=>'sukses'],200);
    }
    
}
