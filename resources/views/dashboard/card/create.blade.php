@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Kartu')
@section('page-title', 'Tambah Kartu')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('card-create')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/cards" method="POST">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('number_card')) has-error @endif">
                        <label class="control-label">Jumlah Kartu</label>
                        <input type="number" class="form-control" name="number_card" value="{{old('number_card')}}">
                        @if($errors->has('number_card')) <p class="help-block">{{ $errors->first('number_card') }}</p> @endif
                    </div>

                    <p>ID Kartu akan digenerate secara otomatis.</p>
                    
                    <div class="form-group text-right">
                        <a href="/u/cards" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection