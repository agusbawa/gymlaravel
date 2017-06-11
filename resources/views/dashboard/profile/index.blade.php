@extends('dashboard._layout.dashboard')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('profile',$user)!!}
@endsection
@section('content')
<div class="row m-b-30">
    <div class="col-sm-12">
        <div class="bg-picture text-center">
            <div class="bg-picture-overlay"></div>
            <div class="profile-info-name">
                <img src="{{($user->avatar!="")?$user->avatar:'http://placehold.it/150x150'}}" class="thumb-lg img-circle img-thumbnail" alt="profile-image">
                <h4 class="m-b-5"><b>{{$user->name}}</b></h4>
            </div>
        </div>
        <!--/ meta -->
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Ubah Profile</b></h4>
            <div class="p-20">
                <form action="/u/profile/me" method="POST" enctype="multipart/form-data">
                {{ method_field('PATCH') }}
                {{ csrf_field() }}
                <div class="about-info-p">
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('username')) has-error @endif">
                        <label class="control-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{old('username',$user->username)}}">
                        @if($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email',$user->email)}}">
                        @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('phone')) has-error @endif">
                        <label class="control-label">Nomor Telp</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone',$user->phone)}}">
                        @if($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('password')) has-error @endif">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" name="password" value="{{old('password')}}">
                        @if($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('password_confirmation')) has-error @endif">
                        <label class="control-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
                        @if($errors->has('password_confirmation')) <p class="help-block">{{ $errors->first('password_confirmation') }}</p> @endif
                    </div>

                    <div class="form-group @if($errors->has('avatar')) has-error @endif">
                        <label for="">Avatar</label>
                        <input type="file" name="avatar" class="form-control">
                        @if($errors->has('avatar')) <p class="help-block">{{ $errors->first('avatar') }}</p> @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-8">
        
    </div>
</div>
@endsection