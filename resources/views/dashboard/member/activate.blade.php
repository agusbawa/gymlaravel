@extends('dashboard._layout.dashboard')
@section('title', 'Aktivasi Member')
@section('page-title', 'Aktivasi Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('aktifasi')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/members/activate" method="GET">
                   
                <div class="card-box">
                    <div class="form-group label-floating">
                        <label class="control-label">Kode Aktifasi</label>
                        <input type="text" class="form-control" name="code" value="{{old('code')}}">
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