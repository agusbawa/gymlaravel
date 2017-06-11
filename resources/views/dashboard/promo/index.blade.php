@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Code Promo')
@section('title', 'Code Promo')
@section('page-title', 'Code Promo')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('promo')!!}
@endsection
@if(\App\Permission::CreatePer('226',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/promos/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Judul</th>
            <th>Kode</th>
            <th>Masa Berlaku</th>
            <th>Jumlah</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
        @if($row->id == '0')
            @continue
        @endif
            <td>{{$row->title}}</td>
            <td>{{$row->code}}</td>
            <td>{{$row->start_date}} s/d {{$row->end_date}}</td>
            <td>{{$row->qty}}</td>
            <td class="text-right">
            <form action="/u/promos/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('226',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('226',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/promos/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection