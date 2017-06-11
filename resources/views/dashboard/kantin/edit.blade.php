@extends('dashboard._layout.dashboard')
@section('title', 'Edit Kantin')
@section('page-title', 'Edit Kantin')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('kantin-edit', $kantin)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/kantin/{{$kantin->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control" id="gym_id" name="gym_id">
                            <option value="">Gym</option>
                            @foreach($gyms as $gym)
                                <option @if(old('gym',$kantin->gym_id)==$gym->id) selected @endif value="{{$gym->id}}" >{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$kantin->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('total')) has-error @endif">
                        <label class="control-label">Total</label>
                        <input type="text" class="form-control" name="total" value="{{old('total',$kantin->total)}}">
                        @if($errors->has('total')) <p class="help-block">{{ $errors->first('total') }}</p> @endif
                    </div>
                    <div class="form-group" id="price"></div>
                     <div class="form-group label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode" onchange="change()" id="metode">
                            <option @if($kantin->payment_method == "CASH") selected @endif value="CASH">Cash</option>
                            <option @if($kantin->payment_method == "EDC") selected @endif value="EDC">EDC</option>
                            <option @if($kantin->payment_method == "lain") selected @endif value="lain">Lain - Lain</option>
                        </select>
                        @if($errors->has('metode')) <p class="help-block">{{ $errors->first('metode') }}</p> @endif
                    </div>
                    <div class="form-group" ></div>
                     <div class="form-group" id="keterangan" label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" value="{{old('keterangan',$kantin->keterangan)}}">
                        @if($errors->has('metode')) <p class="help-block">{{ $errors->first('metode') }}</p> @endif
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
                        <input  @if(\App\User::where('id',Auth::user()->id)->where('tanggal','0')->count() == 1) readonly="true" class="form-control" @else  class="form-control datepicker"  @endif type="text" name="tgl_bayar" value="{{old('tgl_bayar',date('d-m-Y',strtotime($kantin->tgl_bayar)))}}">
                        @if($errors->has('tgl_bayar')) <p class="help-block">{{ $errors->first('tgl_bayar') }}</p> @endif
                    </div>   
                    
                    
                    <div class="form-group text-right">
                        <a href="/u/kantin" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection