@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resoruce-transaction')

@section('help-title', 'Kantin')
@section('title', 'Kantin')
@section('page-title', 'Kantin')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('kantin')!!}
@endsection
@if(\App\Permission::CreatePer('11',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/kantin/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Total</th>
            <th>Gym</th>
            <th>Tanggal</th>
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
            <td>{{$row->name}}</td>
            <td>Rp {{number_format($row->total)}}</td>
            <td>{{$row->gym->title}}</td>
            <td>{{$row->tgl_bayar}}</td>
            <td class="text-right" width="200">
                <form action="/u/kantin/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('11',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('11',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/kantin/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection