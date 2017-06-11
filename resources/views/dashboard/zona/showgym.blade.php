@extends('dashboard._layout.dashboard')


@section('help-title', 'Show Gym')  
@section('title', 'Show Gym')
@section('page-title', 'Show Gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('showgym',$zona)!!}
@endsection

@section('content')
<div class="panel panel-default">
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Member</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($zona as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td>{{$row->address}}</td>
            <td>{{$row->members()->count()}}</td>
            <td class="text-right" width="200"> 
                <form action="/u/gyms/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a href="/u/gyms/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                <a href="/u/gyms/{{$row->id}}"  rel="tooltip" title="Lihat @yield('help-title')" class="btn btn-white btn-simple btn-xs pull-right"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection

