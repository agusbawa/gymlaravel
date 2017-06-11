@extends('dashboard._layout.dashboard')
@section('title', 'Edit Gym')
@section('page-title', 'Edit Gym '.$gym->name)
@section('page-breadcrumb')
    {!!Breadcrumbs::render('gym-edit', $gym)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/gyms/{{$gym->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="title" value="{{old('title', $gym->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('address')) has-error @endif">
                        <label class="control-label">Alamat</label>
                        <textarea class="form-control" rows="5" name="address">{{old('address', $gym->address)}}</textarea>
                        @if($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="">Zona Gym</label>
                        <select name="zona" id="" class="select2 form-control">
                            @foreach($zonas as $zona)
                                <option @if($zona->id == old('zona', $gym->zona_id)) selected @endif value="{{$zona->id}}">{{$zona->title}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Peta Lokasi</label>
                    </div>
                    <div data-type="map" data-search-input=".search-box" data-latbox=".latitude" data-longbox=".longitude" id="map"></div>
                    <p class="help-block">Angkat dan Lepas Pin untuk menentukan lokasi</p>
                    
                    <div class="form-group label-floating">
                        <input type="text" class="form-control search-box">
                        <input type="hidden" name="latitude" class="latitude" value="{{old('latitude', $gym->location_latitude)}}">
                        <input type="hidden" name="longitude" class="longitude" value="{{old('longitude', $gym->location_longitude)}}">
                        <p class="help-block">Ketikan Nama Desa / Kota / Negara. Tekan Tombol Tab untuk memilih lokasi</p>
                    </div>
                    <div class="form-group  @if($errors->has('package')) has-error @endif">
                        <label for="">Kategori Harga</label>
                        <select name="package" id="" class="select2 form-control">
                            @foreach($package as $packages)
                                <option @if(old('package',$gym->package_id)==$packages->id) selected @endif value="{{$packages->id}}">{{$packages->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group label-floating @if($errors->has('supervisor')) has-error @endif">
                        <label class="control-label">Supervisor</label>
                        <input type="text" class="form-control" name="supervisor" value="{{old('supervisor',$gym->supervisor)}}">
                        @if($errors->has('supervisor')) <p class="help-block">{{ $errors->first('supervisor') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('telp')) has-error @endif">
                        <label class="control-label">Telp Supervisor</label>
                        <input type="text" class="form-control" name="telp" value="{{old('telp',$gym->telp)}}">
                        @if($errors->has('telp')) <p class="help-block">{{ $errors->first('telp') }}</p> @endif
                    </div>
                    <div class="form-group @if($errors->has('ownership')) has-error @endif">
                        <label for="">Ownership</label>
                        <select name="ownership" id="" class="select2 form-control">
                            @foreach($ownerType as $owK => $owV)
                                <option @if($owK == old('ownership',$gym->ownership)) selected @endif value="{{$owK}}">{{$owV}}</option>
                            @endforeach
                        </select>
                    </div>
                     <div class="form-group label-floating @if($errors->has('saldo')) has-error @endif">
                        <label class="control-label">Saldo Awal Petty Cash</label>
                        <input type="text" class="form-control" name="saldo" value="{{old('saldo',$gym->saldo_awal)}}">
                        @if($errors->has('saldo')) <p class="help-block">{{ $errors->first('saldo') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('ipaymu_key')) has-error @endif">
                        <label class="control-label">Ipaymu Key</label>
                        <textarea class="form-control" rows="5" name="ipaymu_key">{{old('ipaymu_key', $gym->ipaymu_key)}}</textarea>
                        @if($errors->has('ipaymu_key')) <p class="help-block">{{ $errors->first('ipaymu_key') }}</p> @endif
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/gyms" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection