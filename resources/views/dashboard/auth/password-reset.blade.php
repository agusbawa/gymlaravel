@extends('dashboard.auth.layouts')

@section('title', config('app.name').' - Reset Password')

@section('content')
    <form action="" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}

        <div class="panel-heading">
            <img src="/assets/images/login-header.png" alt="" class="img center-block img-responsive">
            <h3 class="text-center">Reset Password</h3>
        </div>

        <div class="panel-body">
            <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                <label class="control-label">Alamat Email</label>
                <input type="email" class="form-control" name="email"  value="{{$email}}">
                @if($errors->has('email')) <p class="help-block">{{$errors->first('email')}}</p> @endif
            </div>
            <div class="form-group label-floating @if($errors->has('password')) has-error @endif">
                <label class="control-label">Password</label>
                <input type="password" class="form-control" name="password">
                @if($errors->has('password')) <p class="help-block">{{$errors->first('password')}}</p> @endif
            </div>
            <div class="form-group label-floating @if($errors->has('password_confirmation')) has-error @endif">
                <label class="control-label">Konfirmasi Password</label>
                <input type="password" class="form-control" name="password_confirmation">
                @if($errors->has('password_confirmation')) <p class="help-block">{{$errors->first('password_confirmation')}}</p>@endif
            </div>
            <input type="hidden" name="token" value="{{$token}}">
            <div class="form-group">
                <input type="submit" class="btn btn-pink btn-block btn-pink" value="Reset Password">
            </div>
            <div class="text-center">
                <a href="/auth/login" class="btn btn-white btn-sm">Kembali Ke Halaman Login</a>
            </div>
            <div class="text-center">
                <img src="/assets/images/powered-by.png" alt="Powered By">
            </div>
        </div>
    </form>
@endsection