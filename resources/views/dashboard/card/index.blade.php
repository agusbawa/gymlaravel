@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Kartu')
@section('title', 'Kartu')
@section('page-title', 'Kartu')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('card')!!}
@endsection
@if(\App\Permission::CreatePer('20',Auth::user()->role_id) == 0) 
@section("status","hidden=''")
@else
@section("status","")
@endif
@section('add_url', url('u/cards/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Tertaut Ke</th>
            <th class="text-right">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->created_at}}</td>
            <td>{{$row->awal}} s/d {{$row->akhir}}<td>
            
            <td><a href="/u/barcode/pdf/{{$row->interval}}/{{$row->awal}}" title="Print ulang kartu" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><span class="fa fa-print"></span></a><td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection