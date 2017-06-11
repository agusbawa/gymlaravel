@extends('dashboard._layout.dashboard')
@section('title', 'Edit Harga Paket')
@section('page-title', 'Edit Harga Paket')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('package-price-edit', $package, $packagePrice)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/packages/{{$package->id}}/prices/{{$packagePrice->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$packagePrice->title)}}" placeholder="Mis. 3 Bulan">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group @if($errors->has('day')) has-error @endif">
                        <label class="control-label">Lama (Bulan)</label>
                        <input type="number" class="form-control" name="day" value="{{old('day',$packagePrice->day)}}">
                        @if($errors->has('day')) <p class="help-block">{{ $errors->first('day') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('price')) has-error @endif">
                        <label class="control-label">Harga</label>
                        <input type="number" class="form-control" name="price" value="{{old('price',$packagePrice->price)}}">
                        @if($errors->has('price')) <p class="help-block">{{ $errors->first('price') }}</p> @endif
                    </div>
                    
                    <div class="form-group checkbox">
                        <input name="enable_front" value="1" id="checkbox0" type="checkbox" @if((old('enable_front',$packagePrice->enable_front))) checked @endif>
                        <label for="checkbox0">
                            Tampilkan di front page
                        </label>
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/packages/{{$package->id}}/prices" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection