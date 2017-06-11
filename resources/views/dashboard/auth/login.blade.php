@extends('dashboard.auth.layouts')

@section('title',' Halaman Login')

@section('content')
    <div class="panel-heading">
        <img src="/assets/images/login-header.png" alt="" class="img center-block img-responsive">
    </div>

    <div class="panel-body">
        <form class="form-horizontal m-t-20" action="" method="post">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="email" required="" placeholder="Email" name="email">
                </div>
            </div>

            <div class="form-group">
                <div class="col-xs-12">
                    <input class="form-control" type="password" required="" placeholder="Password" name="password">
                </div>
            </div>
            
            @if($errors->has('login'))
                <div class="alert alert-danger">
                    <div class="container-fluid">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{$errors->first('login')}}
                    </div>
                </div>
            @endif

            <div class="form-group text-center m-t-30">
                <div class="col-xs-12">
                    <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                        Masuk
                    </button>
                </div>
            </div>

            <div class="form-group m-t-20 m-b-0">
                <div class="col-sm-12">
                    <a href="/auth/forgot" class="text-dark"><i class="fa fa-lock m-r-5"></i> Lupa password?</a>
                </div>
            </div>
            <div class="text-center">
                <img src="/assets/images/powered-by.png" alt="Powered By">
            </div>
        </form>
    </div>
@endsection