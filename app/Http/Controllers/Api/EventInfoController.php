<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;
use App\Agenda;
use Carbon\Carbon;
class EventInfoController extends Controller
{
   public function index()
   {
        $agenda = Agenda::get();
        return Response::json(['list'=>$agenda],200);
   }
   public function show($id)
   {
        $agenda = Agenda::find($id);
        return Response::json(['promo'=>$agenda],200);
   }
}
