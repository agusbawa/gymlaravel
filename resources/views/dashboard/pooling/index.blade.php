@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Poolings')
@section('title', 'Poolings')
@section('page-title', 'Poolings')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('poolings')!!}
@endsection
@if(\App\Permission::CreatePer('32',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/poolings/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Judul Pooling</th>
            <th>Description</th>
            <th>Enable Registration</th>
            <th>Jumlah item</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->description}}</td>
            <td>
                @if($row->enableregister)
                Enable
                @else
                Not Enable
                @endif
            </td>
            <td>{{$row->voteItems->count()}}</td>
            <td class="text-right" width="200">
                <form action="/u/poolings/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('29',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('32',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/poolings/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                <a @if(\App\Permission::SubMenu('32',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/poolings/{{$row->id}}"  rel="tooltip" title="Lihat @yield('help-title')" class="btn btn-white btn-simple btn-xs pull-right"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection