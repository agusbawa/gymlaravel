@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Petty Cash')
@section('page-title', 'Tambah Petty Cash')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('pettycash-create')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/pettycash" method="POST">
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
                    <div class="form-group label-floating @if($errors->has('total')) has-error @endif">
                        <label class="control-label">Total</label>
                        <input type="text" class="form-control" name="total" value="{{old('total')}}">
                        @if($errors->has('total')) <p class="help-block">{{ $errors->first('total') }}</p> @endif
                    </div>
                    
                    
                    <div class="form-group text-right">
                        <a href="/u/promos" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection