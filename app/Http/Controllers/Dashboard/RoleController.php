<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Gym;
use App\GymUser;
use File;
use App\Zona;
use App\ZonaUser;
use Auth;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if(\App\Permission::SubMenu('270',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        User::bootIndexPage($request->get('keyword'), ['email','phone'],['email'=>'desc']);
        return view('dashboard/role/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  =   Role::orderBy('title','ASC')->get();
        $gyms   =   Gym::orderBy('title','ASC')->get();
        $zonas  =   Zona::orderBy('title','ASC')->get();
        return view('dashboard/role/create')->with('roles',$roles)->with('gyms',$gyms)->with('zonas',$zonas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        \Validator::make($request->all(), [
            'name'                  =>  'required',
            'username'              =>  'required|unique:users,username',
            'email'                 =>  'required|email|unique:users,email',
            'password'              =>  'confirmed|required',
            'phone'                 =>  'required',
            'role'                  =>  'required',
            'tanggal'               =>  '',
            'avatar'                =>  'max:1000000000',
        ])->setAttributeNames([
            'name'                  =>  'Nama',
            'username'              =>  'Username',
            'email'                 =>  'Email',
            'password'              =>  'Password',
            'phone'                 =>  'Nomor Telp',
            'avatar'                =>  'Avatar',
            'tanggal'               =>  'akses merubah tanggal',
        ])->validate();
        $user                   =   new User;
         if ($request->hasFile('avatar')) {
         
        $extension=$request->file('avatar')->getClientOriginalExtension();
        $fileName=rand(11111,99999).'.'.$extension;
        $destinationPath = 'images/avatar/';
       
        $request->file('avatar')->move($destinationPath, $fileName);
        $user->avatar           =   $fileName;
        }
        if($request->get('tanggal')){
            $user->tanggal     = '1';
        }else{
            $user->tanggal     ='0';
        }
        $user->name             =   $request->get('name');
        $user->username         =   $request->get('username');
        $user->email            =   $request->get('email');
        $user->password         =   bcrypt($request->get('password'));
        $user->phone            =   $request->get('phone');
        
        $user->role_id          =   $request->get('role');
        $user->remember_token   =   '';
        $user->save();
        if($request->get('gyms')!=null){
        $user->gyms()->sync($request->get('gyms'));
        }
        if($request->get('zonas')!=null){
        $user->zonas()->sync($request->get('zonas'));
        }

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Pengurus']));
        return redirect('/u/roles/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         if (\App\Permission::EditPer('270',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $user   =   User::findOrFail($id);
        $roles  =   Role::orderBy('title','ASC')->get();
        $gyms   =   Gym::orderBy('title','ASC')->get();
        $gymusers = GymUser::where('user_id','=',$id)->get();
        $zonas  =   Zona::orderBy('title','ASC')->get();
        $zonausers = ZonaUser::where('user_id',$id)->get();
        return view('dashboard/role/edit')->with('roles',$roles)->with('gyms',$gyms)->with('user',$user)->with('zonas',$zonas)->with('zonausers',$zonausers)
        ->with('gymusers',$gymusers);
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
       
        $user                   =   User::findOrFail($id);

        \Validator::make($request->all(), [
            'name'                  =>  'required',
            'username'              =>  'required|unique:users,username,'.$user->id,
            'email'                 =>  'required|email|unique:users,email,'.$user->id,
            'phone'                 =>  'required',
            'role'                  =>  'required',
            'avatar'                =>  'max:1000000000',
        ])->setAttributeNames([
            'name'                  =>  'Nama',
            'username'              =>  'User Name',
            'email'                 =>  'Email',
            'phone'                 =>  'Nomor Telp',
            'avatar'                =>  'Foto',
        ])->validate();
        if ($request->hasFile('avatar')) {
         File::delete('images/avatar/'.User::find($id)->avatar);
        $extension=$request->file('avatar')->getClientOriginalExtension();
        $fileName=rand(11111,99999).'.'.$extension;
        $destinationPath = 'images/avatar/';
       
        $request->file('avatar')->move($destinationPath, $fileName);
        
        }else{
          
          $fileName=User::find($id)->avatar;
        }
        
        $user->name             =   $request->get('name');
        $user->username         =   $request->get('username');
        $user->email            =   $request->get('email');
        //$user->password         =   bcrypt($request->get('password'));
        $user->phone            =   $request->get('phone');
        $user->avatar           =   $fileName;
        if($request->get('tanggal')){
            $user->tanggal     = '1';
        }else{
            $user->tanggal     ='0';
        }
        $user->remember_token   =   '';
        $user->save();
        $gymusers = GymUser::where('user_id','=',$id)->delete();
        $user->gyms()->sync($request->get('gyms',[]));
        $zonauser = ZonaUser::where('user_id','=',$id)->delete();
        $user->zonas()->sync($request->get('zonas',[]));
        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Pengurus']));
        return redirect('/u/roles/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('270',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $user    =   User::findOrFail($id);
         File::delete('images/avatar/'.User::find($id)->avatar);
        $user->gyms()->detach();
        $user->delete();

        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Jabatan']));
        return redirect('/u/roles');
    }
}
