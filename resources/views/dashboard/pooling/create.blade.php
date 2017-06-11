@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Pooling')
@section('page-title', 'Tambah Pooling')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('poolings-create')!!}
@endsection
@section('content')
    <div class="row">
        <form action="/u/poolings" method="POST">
        <div class="col-lg-6">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <label class="control-label">Description</label>
                        <input type="text" class="form-control" name="description" value="{{old('description')}}">
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('enableregister')) has-error @endif">
                        <label class="control-label">Tampilkan pada register member</label>
                        <select name="enableregister" id="" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0" selected>Tidak Aktif</option>
                        </select>
                        @if($errors->has('enableregister')) <p class="help-block">{{ $errors->first('enableregister') }}</p> @endif
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/poolings" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
        </div>
        <div class="col-lg-6">
            <div class="card-box">
                <button type="button" id="tambahVoteItem" class="btn btn-danger">Add Vote Item</button>
                <div id="addItemdata"></div>
            </div>
        </div>
        </form>
    </div>
@endsection