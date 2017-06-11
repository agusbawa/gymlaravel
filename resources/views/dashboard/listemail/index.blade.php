@extends('dashboard._layout.dashboard')

@section('help-title', 'Gym Harian')
@section('title', 'Gym Harian')
@section('page-title', 'Gym Harian')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('listemail')!!}
@endsection
@section('content')
 <div class="row">
    <div class="col-md-6">
        <div @if(\App\Permission::CreatePer('223',Auth::user()->role_id) == 0) hidden="" @endif class="form-group">
            <a href="/u/listemail/create"  class="btn btn-default"><span class="fa fa-plus"></span> List Email</a>
        </div>
    </div>

    <div class="col-md-6">
        <form action="/u/listemail" class="form-inline" method="GET" style="float: right;">
            <div class="form-group label-floating">
                <label class="control-label">Keyword Pencarian</label>
                    <input type="text" class="form-control" name="keyword">
            </div>
            <div class="form-group">
                <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
            </div>  
        </form>
    </div>
</div>

<div class="panel panel-default table-responsive">
<table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td class="text-right" width="200">
                <form action="/u/listemail/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('223',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif  class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('223',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/listemail/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</div>
{{$table->links()}}
@endsection