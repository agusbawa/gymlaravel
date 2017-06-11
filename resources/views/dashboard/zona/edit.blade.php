@extends('dashboard._layout.dashboard')
@section('title', 'Edit Zona')
@section('page-title', 'Edit Zona')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('zona-edit',$zona)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/zonas/{{$zona->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Nama Zona</label>
                        <input type="text" class="form-control" name="title" value="{{old('title', $zona->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <textarea name="description" id="" cols="30" rows="10" class="summernote">{{old('description',$zona->description)}}</textarea>
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/zonas" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection