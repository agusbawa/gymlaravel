@extends('dashboard._layout.dashboard')


@section('help-title', 'List Harga')
@section('title', 'List Harga')
@section('page-title', 'List Harga')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('packagelist')!!}
@endsection

@section('content')
<div class="row">
 <div class="col-md-4">
                <div @if(\App\Permission::CreatePer('27',Auth::user()->role_id) == 0) hidden="" @endif class="form-group">
                    <a href="packageprices/create" class="btn btn-default"><span class="fa fa-plus"></span> @yield('title')</a>
                </div>
            </div>
            <div class="col-md-8 text-right">
                <form action="/u/searchpackage" class="form-inline" method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                    <div class="form-group label-floating">
                    <label class="control-label">Category harga</label>
                        <select name="kategori" class="form-control">
                        <option value="" selected>Semua</option>
                            @foreach($pakets as $paket)
                                <option value="{{$paket->id}}" @if($paket->id == $selpaket) selected @endif>{{$paket->title}}</option>
                            @endforeach
                        </select>
                    </div>
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
        </br>
 <div class="panel panel-default table-responsive">      
<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Lama</th>
            <th>Harga</th>
            <th>Category</th>
            <th>Tampilkan di Front Page</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
         @if($row->package == null )
            @continue
        @else
        <tr>
       
            <td>{{$row->title}}</td>
            <td>{{$row->day}} hari</td>
            <td> Rp {{number_format($row->price,2)}}</td>
            <td>{{$row->package->title}}</td>
            <td>
            @if($row->enable_front == 1)
            Ya
            @else($row->enable_front == 0)
            Tidak
            @endif
            </td>
            
            <td class="text-right" width="200">
                <form action="/u/packageprices/{{$row->id}}" class="pull-right confirm m-l-5" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button @if(\App\Permission::DeletePer('27',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif class="btn btn-simple btn-white btn-xs btn-confirm waves-effect waves-light btn-icon" rel="tooltip" title="Hapus @yield('help-title')"><i class="fa fa-times"></i></button>
                </form>
                <a @if(\App\Permission::EditPer('27',Auth::user()->role_id) == 0) style="visibility: hidden;" @endif href="/u/packageprices/{{$row->id}}/edit"  rel="tooltip" title="Edit @yield('help-title')" class="btn btn-simple btn-white btn-xs m-l-5  pull-right"><i class="fa fa-pencil"></i></a>
                
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
 </div>
{{$table->links()}}


@endsection