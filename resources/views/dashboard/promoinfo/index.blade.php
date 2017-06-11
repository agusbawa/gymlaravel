@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Promo Info')
@section('title', 'Promo Info')
@section('page-title', 'Promo Info')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('promoinfo')!!}
@endsection
@if(\App\Permission::CreatePer('29',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/promoinfo/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Status</th>
            <th>Promo dimulai</th>
            <th>Promo berakhir</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->status}}</td>
            <td>{{$row->harimulai}}</td>
            <td>{{$row->hariakhir}}</td>
            <td class="text-right" width="200">
                <form action="/u/promoinfo/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('29',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('29',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/promoinfo/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection