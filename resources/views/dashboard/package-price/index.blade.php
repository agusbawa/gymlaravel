@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Harga Paket Gym')
@section('title', 'Harga Paket Gym')
@section('page-title', 'Harga Paket Gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('package-price', $package)!!}
@endsection
@section('add_url', url('u/packages/'.$package->id.'/prices/create'))
@section('table')
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Lama</th>
            <th>Harga</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->day}} hari</td>
            <td>{{number_format($row->price)}}</td>
            <td class="text-right" width="200">
                <form action="/u/packages/{{$package->id}}/prices/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a href="/u/packages/{{$package->id}}/prices/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('analitycs')
    <div class="m-b-15">
        <div class="portlet">
            <div class="portlet-heading">
                <h3 class="portlet-title text-dark">
                    Pembelian Paket Gym
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="portlet-body">
                <div class="package-buy" style="height:300px;"></div>
            </div>
        </div>
    </div>
    <hr>
@endsection