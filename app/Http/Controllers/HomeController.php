<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /*protected $layout = "dashboard._layout.dashboard";
    public function showWelcome()
    {
        $items = Permission::get();

        $this->layout->content = View::make('dashboard._layout.dashboard')->with('items',$items);
    }*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
