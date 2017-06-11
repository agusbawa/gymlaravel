<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Gym;
use App\Zona;
use View;
use Auth;
use App\GymUser;
class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(\App\Permission::SubMenu('24',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Zona::bootIndexPage($request->get('keyword'), ['title'],['title'=>'asc']);
        return view('dashboard.zona.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.zona.create');
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
        ])->setAttributeNames([
            'title'              =>'Nama Zona',
        ])->validate();

        $zona                =   new Zona;
        $zona->title         =   $request->get('title');
        $zona->description = $request->get('description');
        $zona->save();

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Zona']));
        return redirect('/u/zonas/');
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
         if (\App\Permission::EditPer('24',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $zona                =   Zona::findOrFail($id);
        return view('dashboard.zona.edit')->with('zona',$zona);
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
        ])->setAttributeNames([
            'title'              =>'Nama Paket',
        ])->validate();

        $zona                =   Zona::findOrFail($id);
        $zona->title         =   $request->get('title');
        $zona->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Zona']));
        return redirect('/u/zonas/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('24',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $zona    =   Zona::findOrFail($id);
        if ($zona->gyms()->count()>0) {
        	request()->session()->flash('alert-error', trans('regym.fail_deleting', ['barrier_count' => $zona->gyms()->count(),'barrier'=>'Gym']));
        	return redirect()->back();
        }
        $zona->delete();
        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Zona']));
        return redirect('/u/zonas');
    }

    public function showgym($id){
         $keyword="";
            View::share('keyword',$keyword);
            $zone = Zona::findOrFail($id);
            $zonas = Zona::orderBy('title','asc')->get();
        if(\App\Permission::CheckGym(Auth::user()->id)==1){
            $gymuser = GymUser::where('user_id',Auth::user()->id);
            $gym = Gym::orderBy('title','asc');
              foreach($gymuser as $user){
                  $gym->where('id',$user);
              }
              $table = $gymuser->paginate(15);
             
            return view('dashboard.gym.index')->with('zonas',$zonas)->with('zone',$zone->id)->with('table',$table);
        }else{
           
            
            $table = Gym::orderBy('title','asc')->where('zona_id',$id)->paginate(15);
            
            return view('dashboard.gym.index')
            ->with('zonas',$zonas)
            ->with('table',$table)
            ->with('zone',$zone->id)
            ;
        }
        
    }
}
