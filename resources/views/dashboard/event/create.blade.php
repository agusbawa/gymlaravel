@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Event')
@section('page-title', 'Tambah Event')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('event-create')!!}
@endsection
@section('content')
    <div class="row">
        <form action="/u/events" method="POST">
        <div class="col-lg-6">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul Event</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('tgl_event')) has-error @endif">
                        <label class="control-label">Tanggal Event</label>
                        <input type="text" class="form-control input-daterange-datepicker" placeholder="Tanggal Event" name="tgl_event" value="{{old('tgl_event')}}">
                        @if($errors->has('tgl_event')) <p class="help-block">{{ $errors->first('tgl_event') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('jam')) has-error @endif">
                        <label class="control-label">Jam Mulai</label>
                        <input type="text" class="form-control" name="jam" value="{{old('jam')}}">
                        @if($errors->has('jam')) <p class="help-block">{{ $errors->first('jam') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('jamberakhir')) has-error @endif">
                        <label class="control-label">Jam Berakhir</label>
                        <input type="text" class="form-control" name="jamberakhir" value="{{old('jamberakhir')}}">
                        @if($errors->has('jamberakhir')) <p class="help-block">{{ $errors->first('jamberakhir') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('tempat')) has-error @endif">
                        <label class="control-label">Tempat</label>
                        <input type="text" class="form-control" name="tempat" value="{{old('tempat')}}">
                        @if($errors->has('tempat')) <p class="help-block">{{ $errors->first('tempat') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('deskripsi')) has-error @endif">
                        <textarea name="deskripsi" id="" cols="30" rows="10" class="summernote">{{old('deskripsi')}}</textarea>
                        @if($errors->has('deskripsi')) <p class="help-block">{{ $errors->first('deskripsi') }}</p> @endif
                    </div>

                    
                    <div class="form-group text-right">
                        <a href="/u/events" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
        </div>        
        </form>
    </div>
@endsection