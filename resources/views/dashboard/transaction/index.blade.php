@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Transaksi')
@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('transaksi')!!}
@endsection
@section('add_url', url('u/transactions/create'))
@section('table')

<table class="table">
    <thead>
        <tr>
            <th>Nama Member</th>
            <th>Gym</th>
            <th>Invoice</th>
            <th>Jenis Paket</th>
            <th>Promo</th>
            <th>Jenis Payment</th>
            <th>Total</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
       @foreach($table as $row)
        <tr>
        	<td>{{$row->member->name}}</td>
        	<td>{{$row->gym->title}}</td>
            <td>{{$row->code}}</th>
        	<td>{{$row->packageprice->title}}</td>
        	<td>{{$row->title}}
            <td>{{$row->payment_method}}</td>
            <td>{{$row->total}}</td>
            <td>{{$row->status}}</td>
            <td class="text-right" width="200">
            	@if($row->status == "Pending")
                <form action="/u/transactions/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a href="/u/transactions/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                
                @else

                
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection