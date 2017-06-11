@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Training Schedule')
@section('page-title', 'Tambah Training Schedule')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('schedule-create')!!}
@endsection
@section('content')
    <div class="row">
        <form action="/u/schedule" method="POST">
        <div class="col-lg-6">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control" id="gym_id" name="gym_id">
                            <option value="">Gym</option>
                            @foreach($gyms as $gym)
                                <option @if(old('gym')==$gym->id) selected @endif value="{{$gym->id}}" data-package="{{$gym->package}}">{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul Training</label>
                        <input type="text" class="form-control" name="title" value="{{old('title')}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('tgl_training')) has-error @endif">
                        <label class="control-label">Tanggal Training</label>
                        <input type="text" class="form-control datepicker" placeholder="Tanggal Training" name="tgl_training" value="{{old('tgl_training')}}">
                        @if($errors->has('tgl_training')) <p class="help-block">{{ $errors->first('tgl_training') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('jam')) has-error @endif">
                        <label class="control-label">Jam Training</label>
                        <input type="text" class="form-control" name="jam" value="{{old('jam')}}">
                        @if($errors->has('jam')) <p class="help-block">{{ $errors->first('jam') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('durasi')) has-error @endif">
                        <label class="control-label">Durasi</label>
                        <input type="text" class="form-control" name="durasi" value="{{old('durasi')}}">
                        @if($errors->has('durasi')) <p class="help-block">{{ $errors->first('durasi') }}</p> @endif
                    </div>
                     <div class="form-group label-floating @if($errors->has('instruktur')) has-error @endif">
                        <label class="control-label">Instruktur</label>
                        <input type="text" class="form-control" name="instruktur" value="{{old('instruktur')}}">
                        @if($errors->has('instruktur')) <p class="help-block">{{ $errors->first('instruktur') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('profile_trainer')) has-error @endif">
                        <textarea name="profile_trainer" id="" cols="30" rows="10" class="summernote">{{old('profile_trainer')}}</textarea>
                        @if($errors->has('profile_trainer')) <p class="help-block">{{ $errors->first('profile_trainer') }}</p> @endif
                    </div>
                    
                    
                    <div class="form-group text-right">
                        <a href="/u/schedule" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
        </div>        
        </form>
    </div>
@endsection