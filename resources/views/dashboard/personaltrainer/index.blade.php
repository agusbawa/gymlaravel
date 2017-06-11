@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resoruce-transaction')

@section('help-title', 'Personal Trainer')
@section('title', 'Personal Trainer')
@section('page-title', 'Personal Trainer')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('personaltrainer')!!}
@endsection
@if(\App\Permission::CreatePer('10',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/personaltrainer/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Nama Trainer</th>
            <th>Nama Member</th>
            <th>Fee Trainer</th>
            <th>Fee Gym</th>
            <th>Gym</th>
            <th>Tanggal</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->member->name}}</td>
            <td>Rp {{number_format($row->fee_trainer)}}</td>
            <td>Rp {{number_format($row->fee_gym)}}</td>
            <td>{{$row->gym->title}}</td>
            <td>{{$row->tgl_bayar}}</td>
            <td class="text-right" width="200">
                <form action="/u/personaltrainer/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('10',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('10',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/personaltrainer/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection