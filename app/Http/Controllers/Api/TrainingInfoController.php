<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Trainingschedule;
use Carbon\Carbon;
class TrainingInfoController extends Controller
{
   public function index()
   {
        $training = Trainingschedule::where([
            ['tgl_training','>=',date('Y-m-d')]
            ])->get();
        
        $list = [];
        
        foreach($training as $tr){
            $tr->gym;
            $list[] = $tr;
//            $list[] = [
//              'training' => $tr,
//              'gym' => $tr->gym  
//            ];
        }
        
        return Response::json(['list'=>$list],200);
   }
   
}
