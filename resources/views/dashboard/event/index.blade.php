@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Event')
@section('title', 'Event')
@section('page-title', 'Event')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('event')!!}
@endsection
@if(\App\Permission::CreatePer('31',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@endif
@section("status","")
@section('add_url', url('u/events/create'))

@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Start Hari</th>
            <th>Hari Berakhir</th>
            <th>Jam Event</th>
            <th>Tempat</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{date('d M Y',strtotime($row->date))}}</td>
            <td>{{date('d M Y',strtotime($row->end_date))}}</td>
            <td>{{$row->start_time}}</td>
            <td>{{$row->tempat}}</td>
            <td class="text-right" width="200">
                <form action="/u/events/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('31',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('31',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/events/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection