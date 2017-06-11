@extends('dashboard._layout.dashboard')
@section('help-title', 'Gym')
@section('title', 'Gym')
@section('page-title', 'Gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('gym')!!}
@endsection
@section('content')
<div class="row">
 <div class="col-md-4">
                <div @if(\App\Permission::CreatePer('25',Auth::user()->role_id) == 0) hidden="" @endif class="form-group">
                    <a href="gyms/create" class="btn btn-default"><span class="fa fa-plus"></span> @yield('title')</a>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <form action="/u/searchgym" class="form-inline" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                    <div class="form-group label-floating">
                    <label class="control-label">Zona</label>
                        <select name="kategori" class="form-control">
                        <option value="" selected>Semua</option>
                           @foreach($zonas as $zona)
                                <option value="{{$zona->id}}" @if($zone == $zona->id) selected @endif>{{$zona->title}}</option>
                           @endforeach
                        </select>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Keyword Pencarian</label>
                        <input type="text" class="form-control" name="keyword" value="{{$keyword}}">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
                    </div>  
                </form>
            </div>
        </div>
        </br>
         <div class="panel panel-default table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Zona</th>
            <th>Supervisor</th>
            <th>Kategori Harga</th>
            <th>Member</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
    @if(\App\Permission::CheckGym(Auth::user()->id)==0)
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->address}}</td>
            <td>{{$row->zona->title}}</td>
            <td>{{$row->supervisor}}</td>
             <td>{{$row->package->title}}</td>
            <td class="text-right"><a href="/u/members/?gyms[]={{$row->id}}&expiredtype=&expiredRange=&keyword=">@if($row->members()==null) @else{{$row->members()->count()}}@endif</a></td>
            <td class="text-right" width="200"> 
                <form action="/u/gyms/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  href="/u/gyms/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                <a @if(\App\Permission::SubMenu('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  href="/u/gyms/{{$row->id}}"  rel="tooltip" title="Lihat @yield('help-title')" class="btn btn-white btn-simple btn-xs pull-right"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
        @else
        @foreach($table as $row)
        <tr>
        <?php
        if($keyword=="" && $zone!=""){
            
            $gym = \App\Gym::orderBy('title','asc')->where('id',$row->gym_id)->where('zona_id',$zone)->first();
            }else if($keyword!="" && $zone==""){
            $gym = \App\Gym::orderBy('title','asc')->where('id',$row->gym_id)->where('title','like','%'.$keyword.'%')->first();
            }else if($keyword!="" && $zone!=""){
            $gym = \App\Gym::orderBy('title','asc')->where('id',$row->gym_id)->where('zona_id',$zone)->where('title','like','%'.$keyword.'%')->first();
            }else{
            $gym = \App\Gym::orderBy('title','asc')->where('id',$row->gym_id)->first();
            }
            
        ?>
        @if($gym == null)

        @else
            <td>{{$gym->title}}</td>
            <td>{{$gym->address}}</td>
            <td>{{$gym->zona->title}}</td>
            <td>{{$gym->supervisor}}</td>
             <td>{{$gym->package->title}}</td>
            <td class="text-right"><a href="/u/members/?gyms[]={{$gym->id}}&expiredtype=&expiredRange=&keyword=">@if($gym->members()==null) @else{{$gym->members()->count()}}@endif</a></td>
            <td class="text-right" width="200"> 
                <form action="/u/gyms/{{$gym->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  href="/u/gyms/{{$gym->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                <a @if(\App\Permission::SubMenu('25',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  href="/u/gyms/{{$gym->id}}"  rel="tooltip" title="Lihat @yield('help-title')" class="btn btn-white btn-simple btn-xs pull-right"><i class="fa fa-eye"></i></a>
            </td>
             @endif
        </tr>
       
        @endforeach
        @endif
    </tbody>
</table>

</div>
{{$table->links()}}
@endsection