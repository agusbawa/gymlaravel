@extends('dashboard._layout.dashboard')


@section('help-title', 'Tiket Support')
@section('title', 'Tiket Support')
@section('page-title', 'Tiket Support')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('tikketsupport')!!}
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 text-right">
                <form action="" class="form-inline" method="POST">
                    <div class="form-group label-floating">
                        <label class="control-label">Keyword Pencarian</label>
                        <input type="text" class="form-control" name="keyword" value="">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
                    </div>  
                </form>
            </div>
</div>
<br/>
 <div class="panel panel-default table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Title</th>
            <th class="text-right">action</th>
        </tr>
    </thead>
    <tbody>
       @foreach($table as $row)
       @if($row->member == null)
            @continue
    @else
    @endif
        <tr>
        
        <td>{{$row->member->name}}</td>
        <td>{{$row->title}}</td>
            <td class="text-right" width="200">
            	
                <form action="" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('33',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('33',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/tiketsupport/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
 <div class="panel panel-default">
@endsection