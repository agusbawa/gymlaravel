@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Setoran Bank')
@section('page-title', 'Tambah Setoran Bank')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('storan-create')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/storan" method="POST">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control" id="gym_id" name="gym_id">
                              @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                 
                                    <option  @if(old('gym_id')==$gym->id) selected @endif @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @else
                             <option selected value="">Semua        </option>
                              <option value="" selected>Gym</option>
                                @foreach($gyms as $gym)
                                    <option @if(old('gym_id')==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('bank')) has-error @endif">
                        <label class="control-label">Nama Bank</label>
                        <input type="text" class="form-control" name="bank" value="{{old('bank')}}">
                        @if($errors->has('bank')) <p class="help-block">{{ $errors->first('bank') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('rekening')) has-error @endif">
                        <label class="control-label">No Rekening</label>
                        <input type="text" class="form-control" name="rekening" value="{{old('rekening')}}">
                        @if($errors->has('rekening')) <p class="help-block">{{ $errors->first('rekening') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('total')) has-error @endif">
                        <label class="control-label">Total</label>
                        <input type="text" class="form-control" id="total" name="total" value="{{old('total')}}">
                        @if($errors->has('total')) <p class="help-block">{{ $errors->first('total') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('tgl_stor')) has-error @endif">
                        <label class="control-label">Tanggal Setoran</label>
                        <input @if(\App\User::where('id',Auth::user()->id)->where('tanggal','0')->count() == 1) readonly="true" class="form-control" @else  class="form-control datepicker"  @endif type="text" name="tgl_stor" value="{{old('tgl_stor',date('d-m-Y'))}}" >
                        @if($errors->has('tgl_stor')) <p class="help-block">{{ $errors->first('tgl_stor') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('deskripsi')) has-error @endif">
                        <label class="control-label">Deskripsi</label>
                       <textarea name="deskripsi" id="" cols="30" rows="10" class="summernote">{{old('deskripsi')}}</textarea>
                        @if($errors->has('deskripsi')) <p class="help-block">{{ $errors->first('deskripsi') }}</p> @endif
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/storan" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection