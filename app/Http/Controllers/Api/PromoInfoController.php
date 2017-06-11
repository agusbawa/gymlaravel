<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Promoinfo;
use Carbon\Carbon;
class PromoInfoController extends Controller
{
   public function index()
   {
        $promo = PromoInfo::get();
        return Response::json(['list'=>$promo],200);
   }
   public function show($id)
   {
        $promo = PromoInfo::find($id);
        return Response::json(['promo'=>$promo],200);
   }
}
