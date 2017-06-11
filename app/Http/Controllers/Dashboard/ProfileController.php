<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         if(\App\Permission::SubMenu('272',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        $user   =   Auth::user();
        return view('dashboard.profile.index')->with('user',$user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $user                       =   Auth::user();

        \Validator::make($request->all(), [
            'name'                  =>  'required',
            'username'              =>  'required|unique:users,username,'.$user->id,
            'email'                 =>  'required|email|unique:users,email,'.$user->id,
            'phone'                 =>  'required',
            'password'              =>  'confirmed',
            'avatar'                =>  'image'
        ])->setAttributeNames([
            'name'                  =>  'Nama',
            'username'              =>  'User Name',
            'email'                 =>  'Email',
            'phone'                 =>  'Nomor Telp',
        ])->validate();

        $user->name         =   $request->get('name');
        $user->username         =   $request->get('username');
        $user->email            =   $request->get('email');
        $user->password         =   bcrypt($request->get('password'));
        $user->phone            =   $request->get('phone');

        if ($request->has('password')) {
            $user->password         =   bcrypt($request->get('password'));
        }

        if ($request->hasFile('avatar')) {
            $user->avatar       =   $request->avatar->store('profile');
            $request->session()->flash('alert-success', 'Password berhasil diubah');
        }

        $user->save();

        $request->session()->flash('alert-success', trans('regym.success_updated', ['name' => 'Pengurus']));
        return redirect('/u/profile');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
