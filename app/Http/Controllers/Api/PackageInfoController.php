<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Gym;
use App\PackagePrice;
use Carbon\Carbon;
class PackageInfoController extends Controller
{
    //
    public function index(){
    	return Response::json(['text'=>'hai'],200);
    }
    public function listdata(){
        $data = PackagePrice::where('enable_front',true)->get();
        return Response::json(['list'=>$data],200);
    }
    
}
