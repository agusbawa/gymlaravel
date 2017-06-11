@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Personal Trainer')
@section('page-title', 'Tambah Personal Trainer')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('personaltrainer-create')!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/personaltrainer" method="POST">
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
                    
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama Trainer</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                     <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Member</label>
                        <select class="form-control select2" name="member_id">
                            <option value="">Member</option>
                            @foreach($members as $member)
                                <option @if(old('member_id',$member->id)==$member->id) selected @endif value="{{$member->id}}">{{$member->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('member_id')) <p class="help-block">{{ $errors->first('member_id') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('fee_trainer')) has-error @endif">
                        <label class="control-label">Fee Trainer</label>
                        <input type="text" id="feetrainer" class="form-control" name="fee_trainer" value="{{old('fee_trainer')}}">
                        @if($errors->has('fee_trainer')) <p class="help-block">{{ $errors->first('fee_trainer') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('fee_gym')) has-error @endif">
                        <label class="control-label">Fee Gym</label>
                        <input type="text" id="feegym" class="form-control" name="fee_gym" value="{{old('fee_gym')}}">
                        @if($errors->has('fee_gym')) <p class="help-block">{{ $errors->first('fee_gym') }}</p> @endif
                    </div>
                    <div class="form-group" id="price"></div>
                     <div class="form-group label-floating ">
                        <label class="control-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode" onchange="change()" id="metode">
                            <option @if(old('metode')=='CASH') selected @endif value="CASH">Cash</option>
                            <option @if(old('metode')=='EDC') selected @endif value="EDC">EDC</option>
                            <option @if(old('metode')=='lain') selected @endif value="lain">Lain - Lain</option>
                        </select>
                        
                    </div>
                    <div class="form-group" ></div>
                     <div class="form-group" id="keterangan" label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="{{old('keterangan')}}">
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div>
                    <script>
                        function tampil(){
                                   var x = document.getElementById("metode");
                                   $("#keterangan").show();
                                   console.log('hai');
                                   if(x.value=="CASH"  ){
                                    $("#keterangan").hide();
                                   }else{
                                    $("#keterangan").show();  
                                   }
                                   console.log(x.value);
                                }
                        function change(){
                                var x = document.getElementById("metode");
                                   $("#keterangan").show();
                                   console.log('hai');
                                   if(x.value=="CASH"  ){
                                    $("#keterangan").hide();
                                   }else{
                                    $("#keterangan").show();  
                                   }
                        }
                                $(document).ready(function(){
                                    tampil();
                                });
                    </script>
                     <div class="form-group label-floating @if($errors->has('tgl_bayar')) has-error @endif">
                        <label class="control-label">Tanggal Bayar</label>
                        <input  @if(\App\User::where('id',Auth::user()->id)->where('tanggal','0')->count() == 1) readonly="true" class="form-control" @else  class="form-control datepicker"  @endif type="text" name="tgl_bayar" value="{{old('tgl_bayar',date('d-m-Y'))}}">
                        @if($errors->has('tgl_bayar')) <p class="help-block">{{ $errors->first('tgl_bayar') }}</p> @endif
                    </div>   
                    
                    <div class="form-group text-right">
                        <a href="/u/personaltrainer" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection