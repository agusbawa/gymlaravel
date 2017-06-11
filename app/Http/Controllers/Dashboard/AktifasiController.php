<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Aktifasi;
class AktifasiController extends Controller
{
    //
    public function index(){
      Transaction::bootIndexPage($request->get('keyword'), ['name'],['created_at'=>'asc']);
      return view('dashboard.transaction.index'); 
    }
}
