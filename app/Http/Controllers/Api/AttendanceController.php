<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Attendance;
use Carbon\Carbon;
class AttendanceController extends Controller
{
   public function index(Request $request)
   {
        $checkin = Attendance::where(['member_id'=>$request->get('member_id')])->orderBy('id','DESC')->get();
        $dCheckin = array();
        foreach($checkin as $ch){
            $ch->gym;
            $dCheckin[] = $ch;
        }
        return Response::json(['list'=>$dCheckin],200);
   }
}
