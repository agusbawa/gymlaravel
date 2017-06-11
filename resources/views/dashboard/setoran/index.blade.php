@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resoruce-transaction')

@section('help-title', 'Setoran Bank')
@section('title', 'Setoran Bank')
@section('page-title', 'Setoran Bank')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('storan')!!}
@endsection
@if(\App\Permission::CreatePer('13',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/storan/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Bank</th>
            <th>Rekening</th>
            <th>Total</th>
            <th>Tanggal Setoran</th>
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
            <td>{{$row->bank}}</td>
            <td>{{$row->rekening}}</td>
            <td>Rp {{number_format($row->total)}}</td>
            <td>{{$row->tgl_stor}}</td>
            <td>{{$row->gym->title}}</td>
            <td class="text-right" width="200">
                <form action="/u/storan/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('13',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('13',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/storan/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection