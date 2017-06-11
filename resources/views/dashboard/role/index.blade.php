@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Pengurus')
@section('title', 'Pengurus')
@section('page-title', 'Pengurus')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('role')!!}
@endsection
@if(\App\Permission::CreatePer('270',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/roles/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        @if($row->role == null)
            @continue
    @else
    @endif
        <tr>
            <td>{{$row->username}}</td>
            <td>{{$row->email}}</td>
            <td>{{$row->role->title}}</td>
            <td class="text-right" width="200">
                <form action="/u/roles/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('270',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('270',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/roles/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection