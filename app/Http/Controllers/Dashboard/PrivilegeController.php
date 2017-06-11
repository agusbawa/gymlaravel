<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Role;
use App\Permission;
use App\ListMenu;
use App\Gym;
use App\PermissionRole;
use DB;
use Auth;
class PrivilegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if(\App\Permission::SubMenu('271',Auth::user()->role_id) == 0){
            return redirect()->back();
      }
        Role::bootIndexPage($request->get('keyword'), ['title'],['title'=>'asc']);
        return view('dashboard.privilege.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions        =   Permission::orderBy('id','ASC')->where('parent','=','0')->get();
        $gyms               =   Gym::get();
        $lists              =   ListMenu::orderBy('title','ASC')->get();
        $permiss_dash = DB::table('permissions')->where('parent','0')->get();
        $permiss_trans = DB::table('permissions')->where('parent','1')->get();
        $permiss_member = DB::table('permissions')->where('parent','2')->get();
        $permiss_gym = DB::table('permissions')->where('parent','3')->get();
        $permiss_kom = DB::table('permissions')->where('parent','4')->get();
        $permiss_aku = DB::table('permissions')->where('parent','5')->get();
        $permiss_lap = DB::table('permissions')->where('parent','6')->get();
        $permiss_pen = DB::table('permissions')->where('parent','7')->get();
        return view('dashboard.privilege.create',compact('permiss_dash','permiss_trans','permiss_member','permiss_gym','permiss_kom','permiss_aku','permiss_lap','permiss_pen'))->with('permissions',$permissions)->with('lists',$lists)->with('gyms',$gyms);
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
            'permissions.*'        =>'required',
        ])->setAttributeNames([
            'title'              =>'Jabatan',
            'permissions'        =>'Hak Akses',
        ])->validate();


        $dash  = $request->get('dash');
        $id_dashku = $request->get('dashku');

        $role                 =   new Role;
        $role->title          =   $request->get('title');
        $role->save();

   
        foreach ($id_dashku as $id_dashkus) {
            if(empty($dash[$id_dashkus]['create'])){
                $dash[$id_dashkus]['create']=0;
            }
            if(empty($dash[$id_dashkus]['update'])){
                $dash[$id_dashkus]['update']=0;
            }
            if(empty($dash[$id_dashkus]['delete'])){
                $dash[$id_dashkus]['delete']=0;
            }

            $permission    =   new PermissionRole;
            $permission->permission_id = $id_dashkus;
            $permission->role_id = $role->id; 
            $permission->lihat = 1;
            $permission->create = $dash[$id_dashkus]['create'];
            $permission->update = $dash[$id_dashkus]['update'];
            $permission->delete = $dash[$id_dashkus]['delete'];
            $permission->save();
        }   
        
        return redirect('/u/privileges');
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
         if (\App\Permission::EditPer('271',Auth::user()->role_id) == 0){
            return redirect()->back();
       }
        $role    =   Role::findOrFail($id);
        $permiss_dash = DB::table('permissions')->where('parent','0')->get();
        $permiss_trans = DB::table('permissions')->where('parent','1')->get();
        $permiss_member = DB::table('permissions')->where('parent','2')->get();
        $permiss_gym = DB::table('permissions')->where('parent','3')->get();
        $permiss_kom = DB::table('permissions')->where('parent','4')->get();
        $permiss_aku = DB::table('permissions')->where('parent','5')->get();
        $permiss_lap = DB::table('permissions')->where('parent','6')->get();
        $permiss_pen = DB::table('permissions')->where('parent','7')->get();
/*$permissions     =   Permission::orderBy('permissions.name','asc')
        ->leftjoin('permission_role','permission_role.permission_id','=','permissions.id')
        ->where('permissions.parent','=','0')
        ->where('permission_role.role_id','=',$id)
        ->get();*/
        $permissions = Permission::orderBy('id','asc')->where('parent','0')->get();
        $selectedPermissions    =   PermissionRole::where('role_id','=',$id)->get();
        /*foreach ($role->permission()->get() as $key => $value) {
            $selectedPermissions[]  =   $value->id;
        }*/

        return view('dashboard.privilege.edit',compact('permiss_dash','permiss_trans','permiss_member','permiss_gym','permiss_kom','permiss_aku','permiss_lap','permiss_pen'))->with('permissions',$permissions)->with('role',$role)->with('selectedPermissions',$selectedPermissions);

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
            'permissions.*'        =>'required',
        ])->setAttributeNames([
            'title'              =>'Jabatan',
            'permissions'        =>'Hak Akses',
        ])->validate();

        $role                 =   Role::findOrFail($id);
        $role->title          =   $request->get('title');
        $role->save();

        /*$foreach ($permissons as $permission) {
        }*/
        $role = PermissionRole::where('role_id',$id);
        $role->delete();

        $dash  = $request->get('dash');
        $id_dashku = $request->get('dashku');

        foreach ($id_dashku as $id_dashkus) {
            if(empty($dash[$id_dashkus]['create'])){
                $dash[$id_dashkus]['create']=0;
            }
            if(empty($dash[$id_dashkus]['update'])){
                $dash[$id_dashkus]['update']=0;
            }
            if(empty($dash[$id_dashkus]['delete'])){
                $dash[$id_dashkus]['delete']=0;
            }

            $permission    =   new PermissionRole;
            $permission->permission_id = $id_dashkus;
            $permission->role_id = $id; 
            $permission->lihat = 1;
            $permission->create = $dash[$id_dashkus]['create'];
            $permission->update = $dash[$id_dashkus]['update'];
            $permission->delete = $dash[$id_dashkus]['delete'];
            $permission->save();
        }  

        $request->session()->flash('alert-success', trans('regym.success_added', ['name' => 'Jabatan']));
        return redirect('/u/privileges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\App\Permission::DeletePer('271',Auth::user()->role_id) == 0){
            return redirect()->back();
       
        }
        $role    =   Role::findOrFail($id);
        
        if ($role->users()->count() > 0) {
            request()->session()->flash('alert-error', trans('regym.fail_deleting', ['barrier_count' => $role->users()->count(),'barrier'=>'User']));
            return redirect()->back();
        }

        $role->permission()->detach();
        $role->delete();

        $permission = PermissionRole::where('role_id',$id);
        $role->delete();

        request()->session()->flash('alert-success', trans('regym.success_deleted', ['name' => 'Jabatan']));
        return redirect('/u/privileges');
    }
}
