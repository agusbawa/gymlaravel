<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\News;
use Auth;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('30',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        News::bootIndexPage($request->get('keyword'), ['title', 'description'],['title'=>'asc']);
        return view('dashboard.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.news.create');
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
            'title'              =>'required',
            'description'        =>'required',
        ])->setAttributeNames([
            'title'              =>'Judul',
            'description'        =>'Pesan',
        ])->validate();

        $news                   =   new News;
        $news->title            =   $request->get('title');
        $news->description      =   $request->get('description');
        $news->status           =   $request->get('status');
        $news->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'News']));
        return redirect('/u/news');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
         if (\App\Permission::EditPer('30',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $news    =   News::findOrFail($id);
        return view('dashboard.news.edit')->with('news',$news);
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
            'title'              =>'required',
            'description'        =>'required',
        ])->setAttributeNames([
            'title'              =>'Judul',
            'description'        =>'Pesan',
        ])->validate();

        $news                   =   News::findOrFail($id);
        $news->title            =   $request->get('title');
        $news->description      =   $request->get('description');
        $news->status           =   $request->get('status');
        $news->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'News']));
        return redirect('/u/news');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('30',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $news    =   News::findOrFail($id);
        $news->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'News']));
        return redirect('/u/news');
    }
}
