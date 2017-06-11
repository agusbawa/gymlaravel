@extends('dashboard._layout.dashboard')
@section('title', 'Edit Code Promo')
@section('page-title', 'Edit Code Promo')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('promo-edit', $promo)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/promos/{{$promo->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Judul</label>
                        <input type="text" class="form-control" name="title" value="{{old('title',$promo->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('code')) has-error @endif">
                        <label class="control-label">Kode Promo</label>
                        <input type="text" disabled class="form-control" name="code" value="{{old('code',$promo->code)}}">
                        @if($errors->has('code')) <p class="help-block">{{ $errors->first('code') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('qty')) has-error @endif">
                        <label class="control-label">Jumlah</label>
                        <input type="number" class="form-control" name="qty" value="{{old('qty',$promo->qty)}}">
                        @if($errors->has('qty')) <p class="help-block">{{ $errors->first('qty') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('range')) has-error @endif">
                        <label class="control-label">Masa Berlaku</label>
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range',$promo->start_date->format('d-m-Y')." - ".$promo->end_date->format('d-m-Y'))}}">
                        @if($errors->has('range')) <p class="help-block">{{ $errors->first('range') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('value')) has-error @endif">
                        <label class="control-label">Diskon</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="number" class="form-control" name="value" value="{{old('value',$promo->value)}}">
                            </div>
                            <div class="col-md-4">
                                <select name="unit" id="" class="form-control">
                                    <option value="PERCENTAGE" @if(old('unit',$promo->unit)=="PERCENTAGE") checked @endif>Persentase</option>
                                    <option value="NOMINAL" @if(old('unit',$promo->unit)=="NOMINAL") checked @endif>Nominal</option>
                                </select>
                            </div>
                        </div>
                        @if($errors->has('value')) <p class="help-block">{{ $errors->first('value') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('paket')) has-error @endif">
                        <label class="control-label">Paket harga</label>
                        <select name="paket[]" id="mySelect" class=" select2" multiple>
                            @foreach($pakets as $paket)
                                <option @foreach($jump as $jum) @if($jum->id==$paket->id) disabled @endif @endforeach  @if(in_array($paket->id,old('paket',[]))) selected @endif  value="{{$paket->id}}">{{$paket->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('paket')) <p class="help-block">{{ $errors->first('paket') }}</p> @endif
                    </div>
                    @foreach($jump as $jum)
                        <p>{{$jum->title}}</p>
                    @endforeach
                    <div class="form-group text-right">
                        <a href="/u/promos" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        
    </script>
@endsection