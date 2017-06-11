@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Paket')
@section('page-title', 'Tambah Paket')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('package-edit', $package)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/packages/{{$package->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Nama Paket</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$package->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/packages" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection