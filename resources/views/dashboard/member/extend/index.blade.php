@extends('dashboard._layout.dashboard')
@section('title', 'Perpanjang Member')
@section('page-title', 'Perpanjang Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-create')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="" method="POST">
                {{ method_field('POST') }}
                {{ csrf_field() }}
                <div class="card-box">
                    <div class="form-group label-floating">
                        <label class="control-label">No Kartu</label>
                        <input type="text" class="form-control" name="member" value="{{old('member')}}">
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/members" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Temukan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection