@extends('dashboard.auth.layouts')

@section('title',' Lupa Passowor')

@section('content')
    <div class="panel-heading">
        <h3 class="text-center">Lupa Password</h3>
    </div>

    <div class="panel-body">
        <form class="form-horizontal m-t-20" action="" method="post">
            {{ csrf_field() }}
            {{ method_field('POST') }}

            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                    ×
                </button>
                Masukan <b>Email</b> Anda dan instruksi reset password akan dikirimkan kepada Anda!
            </div>

            <div class="form-group ">
                <div class="col-xs-12">
                    <input class="form-control" type="email" required="" placeholder="Email" name="email">
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
            <div class="text-center">
                <img src="/assets/images/powered-by.png" alt="Powered By">
            </div>
        </form>
    </div>
@endsection