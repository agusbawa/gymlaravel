@extends('dashboard._layout.dashboard')
@section('title', 'Edit Free Trial')
@section('page-title', 'Edit Free Trial')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('trial-edit', $trial)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/trial/{{$trial->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$trial->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('nick_name')) has-error @endif">
                        <label class="control-label">Nama Panggilan</label>
                        <input type="text" class="form-control" name="nick_name" value="{{old('nick_name',$trial->nick_name)}}">
                        @if($errors->has('nick_name')) <p class="help-block">{{ $errors->first('nick_name') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('gender')) has-error @endif">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="clearfix"></div>
                        <div class="radio radio-pink radio-inline">
                            <input type="radio" name="gender" id="female" value="FEMALE" @if(old('gender',$trial->gender)=="FEMALE" || old('gender',$trial->gender)=="") checked @endif>
                            <label for="female">
                                Perempuan
                            </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="gender" id="male" value="MALE"  @if(old('gender',$trial->gender)=="MALE") checked @endif>
                            <label for="male">
                                Laki Laki
                            </label>
                        </div>
                        @if($errors->has('gender')) <p class="help-block">{{ $errors->first('gender') }}</p> @endif
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating @if($errors->has('place_of_birth')) has-error @endif">
                                <label class="control-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="place_of_birth" value="{{old('place_of_birth',$trial->place_of_birth)}}">
                                @if($errors->has('place_of_birth')) <p class="help-block">{{ $errors->first('place_of_birth') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating @if($errors->has('date_of_birth')) has-error @endif">
                                <label class="control-label">&nbsp;</label>
                                <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir (tanggal/bulan/tahun)" name="date_of_birth" value="{{old('date_of_birth',$trial->date_of_birth->format('d-m-Y'))}}">
                                @if($errors->has('date_of_birth')) <p class="help-block">{{ $errors->first('date_of_birth') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('address_street') || $errors->has('address_region') || $errors->has('address_city')) has-error @endif">
                        <label class="control-label">Alamat</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Jalan" name="address_street" value="{{old('address_street',$trial->address_street)}}">
                                @if($errors->has('address_street')) <p class="help-block">{{ $errors->first('address_street') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kabupaten" name="address_region" value="{{old('address_region',$trial->address_region)}}">
                                @if($errors->has('address_region')) <p class="help-block">{{ $errors->first('address_region') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kota" name="address_city" value="{{old('address_city',$trial->address_city)}}">
                                @if($errors->has('address_city')) <p class="help-block">{{ $errors->first('address_city') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('phone')) has-error @endif">
                        <label class="control-label">No Telepon</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone',$trial->phone)}}">
                        @if($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control select2" name="gym_id">
                            <option value="">Gym Member Mendaftar</option>
                            @foreach($gyms as $gym)
                                <option @if(old('gym',$trial->gym_id)==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    
                    
                    <div class="form-group label-floating @if($errors->has('folow_up_by')) has-error @endif">
                        <label class="control-label">Dihubungi Oleh</label>
                        <input type="text" class="form-control" name="folow_up_by" value="{{old('folow_up_by',$trial->folow_up_by)}}">
                        @if($errors->has('folow_up_by')) <p class="help-block">{{ $errors->first('folow_up_by') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('folow_up')) has-error @endif">
                        <label class="control-label">Dihubungi Pada</label>
                        <input type="text" class="form-control datepicker" name="folow_up" value="{{old('folow_up',$trial->folow_up)}}">
                        @if($errors->has('folow_up')) <p class="help-block">{{ $errors->first('folow_up') }}</p> @endif
                    </div>
                    
                    <div @if($trial->folow_up_by == null) hidden @endif class="form-group label-floating @if($errors->has('tanggal_kedatangan')) has-error @endif">
                        <label class="control-label">Tanggal Kedatangan</label>
                        <input type="text" class="form-control datepicker" name="tanggal_kedatangan" value="{{old('tanggal_kedatangan',$trial->tanggal_kedatangan)}}">
                        @if($errors->has('tanggal_kedatangan')) <p class="help-block">{{ $errors->first('tanggal_kedatangan') }}</p> @endif
                    </div>
                    
                    <div @if($trial->folow_up_by == null) hidden @endif class="form-group label-floating @if($errors->has('status')) has-error @endif">
                        <label class="control-label">Status Kedatangan</label>
                        <select class="form-control select2" name="status">
                            <option value="">Pilih Salah Satu</option>
                            @foreach($status as $statusKey => $statusVal)
                                <option @if(old('status',$trial->status)==$statusKey) selected @endif value="{{$statusKey}}">{{$statusVal}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
                    </div>
                    
                    <div @if($trial->folow_up_by == null) hidden @endif class="form-group label-floating @if($errors->has('remark')) has-error @endif">
                        <label class="control-label">Catatan</label>
                        <textarea class="form-control" name="remark">{{old('remark',$trial->remark)}}</textarea>
                        @if($errors->has('remark')) <p class="help-block">{{ $errors->first('remark') }}</p> @endif
                    </div>
                    
                    
                    <div class="form-group text-right">
                        <a href="/u/trial" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection