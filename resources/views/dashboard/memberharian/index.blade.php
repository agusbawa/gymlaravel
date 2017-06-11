@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resoruce-transaction')

@section('help-title', 'Gym Harian')
@section('title', 'Gym Harian')
@section('page-title', 'Gym Harian')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('memberharian')!!}
@endsection
@if(\App\Permission::CreatePer('9',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/gymharian/create'))
@section('table')

<table class="table">
    <thead>
        <tr>
            <th>Nama Depan</th>
            <th>Panggilan</th>
            <th>Telp.</th>
            <th>Gym</th>
            <th>Nama Paket</th>
            <th>Harga</th>
            <th>Tanggal</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>

        @foreach($table as $row)
        @if(is_null($row->package_price))
            @continue
        @endif
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->nick_name}}</td>
            <td>{{$row->telp}}</td>
            <td>{{$row->titlegym}}</td>
            <td>{{$row->titlepackage}}</td>
            <td>Rp {{number_format($row->price)}}</td>
            <td>{{$row->tgl_bayar}}</td>
            <td class="text-right" width="200">
                <form action="/u/gymharian/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('9',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('9',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/gymharian/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection