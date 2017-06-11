@extends('dashboard._layout.dashboard')

@section('help-title', 'Kategori Harga')
@section('title', 'Kategori Harga')
@section('page-title', 'Kategori Harga')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('package')!!}
@endsection

@section('content')
<div class="row">
 <div class="col-md-4">
                <div @if(\App\Permission::CreatePer('26',Auth::user()->role_id) == 0) hidden="" @endif class="form-group">
                    <a href="packages/create" class="btn btn-default"><span class="fa fa-plus"></span> @yield('title')</a>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <form action="" class="form-inline" method="GET">
                
                
                    <div class="form-group label-floating">
                        <label class="control-label">Keyword Pencarian</label>
                        <input type="text" class="form-control" name="keyword" value="@if(isset($_GET['keyword'])){{$_GET['keyword']}}@endif">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Cari</button>
                    </div>  
                </form>
            </div>
        </div>
        </br>
<div class="panel panel-default table-responsive">

<table class="table">

    <thead>
        <tr>
            <th>Nama</th>
            <th>List Harga</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->title}}</td>
            <td><a href="/u/packageprices/{{$row->id}}" class="showdata-listHarga">{{$row->packagePrice()->count()}} Item</a></td>
            <td class="text-right" width="200">
                <form action="/u/packages/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('26',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('26',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/packages/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" id="modalLIstHarga" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">List Harga</h4>
      </div>
      <div class="modal-body">
          <table class="table placelistharga">
              <thead>
                <tr>
                    <th>Title</th>
                    <th>Lama</th>
                    <th>harga</th>
                </tr>
              </thead>
              <tbody>
                  
              </tbody>
          </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>
@endsection