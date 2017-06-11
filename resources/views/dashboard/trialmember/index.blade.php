@extends('dashboard._layout.dashboard')
@extends('dashboard._layout.resource-index')

@section('help-title', 'Free Trial')
@section('title', 'Free Trial')
@section('page-title', 'Trial Free')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('trial')!!}
@endsection

@section('content')
<div class="row">

            <div class="col-md-12 text-right">
                <form action="" class="form-inline" method="GET">
                    <div class="form-group label-floating">
                        <label class="control-label">Keyword Pencarian</label>
                        <input type="text" class="form-control" name="keyword" value="{{$keyword}}">
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
            <th>Nama</th>
            <th>Panggilan</th>
            <th>Gym</th>
            <th>Dihubungi Oleh</th>
            <th>Dihubungi Tanggal</th>
            <th>Tanggal Kedatangan</th>
            <th>Status Kedatangan</th>
            <th>Action</th>            
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        <tr>
            <td>{{$row->name}}</td>
            <td>{{$row->nick_name}}</td>
            <td>{{$row->gym->title}}</td>
            <td>
            @if($row->folow_up_by == null)
                <a href="/u/trial/{{$row->id}}/edit"  rel="tooltip" title="Dihubungi oleh" class="btn btn-default">Dihubungi Oleh</a>
            @else
                {{$row->folow_up_by}}
            @endif
            </td>
            <td>{{$row->folow_up}}</td>
            <td>{{$row->tanggal_kedatangan}}</td>
            <td> @if($row->status == null && $row->folow_up_by == null)

            @elseif($row->status == null && $row->folow_up_by != null)
                <a href="/u/trial/{{$row->id}}/edit"  rel="tooltip" title="Status Kedatangan" class="btn btn-default">Status Kedatangan</a>
            @elseif($row)
                {{ucfirst($row->status)}}
            @endif</td>
             <td> @if($row->status == null && $row->folow_up_by == null)

            @elseif($row->status == null && $row->folow_up_by != null)
                
            @elseif($row)
                <a href="/u/trialmember/addmember/{{$row->id}}"  rel="tooltip" title="Tambahkan menjadi member" class="btn btn-default">Tambah Member ini</a>
            @endif</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
     {{ $table->links() }}
</div>
@endsection