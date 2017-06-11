@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Training Schedule')
@section('title', 'Training Schedule')
@section('page-title', 'Training Schedule')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('schedule')!!}
@endsection
@if(\App\Permission::CreatePer('28',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/schedule/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Judul Training</th>
            <th>Tanggal Training</th>
            <th>Jam Training</th>
            <th>Durasi</th>
            <th>Instruktur</th>
            <th>Gym</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        @if($row->gym == null)
            @continue
        @else

        @endif
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->tgl_training}}</td>
            <td>{{$row->jam}}</td> 
            <td>{{$row->durasi}}</td>
            <td>{{$row->instruktur}}</td>            
            <td>{{$row->gym->title}}</td>
            <td class="text-right" width="200">
                <form action="/u/schedule/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('28',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a  @if(\App\Permission::EditPer('28',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/schedule/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection