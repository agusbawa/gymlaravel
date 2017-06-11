@extends('dashboard._layout.dashboard')
@section('title', 'Tambah List Email')
@section('page-title', 'Tambah List Email')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('create-list')!!}
@endsection
@section('content')

<div class="panel panel-default">
    <div class="col-md-12">
         <form action="/u/listemail" method="POST">
            <div class="card-box">
            {{ method_field('POST') }}
            {{ csrf_field() }}
             <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                <label class="control-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{old('title')}}">
                @if($errors->has('title')) <p class="help-block">{{ $errors->first('title') }}</p> @endif
            </div>
            
             <div class="form-group label-floating @if($errors->has('usiamin')||$errors->has('usiamax')) has-error @endif">
             <div class="row">
                <div class="col-md-2"><label class="control-label">Range Usia</label></div>
               
               
                <div class="col-md-5">
                    <select name="usiamin"  class="form-control">
                        <option value="" selected>Umur minimal</option>
                        @for($i = 18; $i <60; $i++)
                            <option @if(old('usiamin')) selected @endif value="{{$i}}">{{$i}}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="usiamax"  class="form-control">
                        <option value="" selected>Umur Maksimal</option>
                     @for($i = 18; $i <60; $i++)
                        <option @if(old('usiamax')) selected @endif value="{{$i}}">{{$i}}</option>
                     @endfor
                </select>
            
            
            </div>
             @if($errors->has('usiamin')||$errors->has('usiamax')) <p class="help-block">Range usia mohon diisi lengkap</p> @endif
            </div>
           </div>

            <div class="form-group label-floating"> 
            <div class="row">
                <div class="col-md-2"><label class="control-label">Zona/Gym</label></div>
                <div class="col-md-10"><div class="row">
                    <div class="col-md-6">
                    <select name="zonas[]" class="select2" onclick="zone()" id="zona" multiple>
                        @foreach($zona as $zone)
                            <option  value="{{$zone->id}}">{{$zone->title}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="col-md-6">
                    <select name="gyms[]" class="select2" onclick="gyms()" id="gym" multiple>     
                    @foreach($gym as $gy)
                        <option value="{{$gy->id}}">{{$gy->title}}</option>
                   @endforeach
                    </select>
                    </div>
                </div>
           </div>
            </div>
            </div>
            <script>
            var zona = document.getElementById('zona');
            var gym = document.getElementById('gym');
            function zone(){
                if(zona.value == null){
                    $('#gym').prop('disabled',false);
                    console.log('hai');
                }else{
                $('#gym').prop('disabled',true);
                }
            }
            function gyms(){
                $('#zona').prop('disabled',true);
            }
            </script>
            <div class="form-group label-floating">
            <div class="row">
                        <div class="col-md-2"><label class="control-label">Bulan</label></div>
                        <div class="col-md-10">
                            <select name="month" class="form-control select2">
                              <option value="" selected >PILIH</option>
                                    <option @if(old('month')=="01") selected @endif value="1">Januari</option> 
                                    <option @if(old('month')=="02") selected @endif value="2">Februari</option>
                                    <option @if(old('month')=="03") selected @endif value="3">Maret</option>
                                    <option @if(old('month')=="04") selected @endif value="4">April</option>
                                    <option @if(old('month')=="05") selected @endif value="5">Mei</option>
                                    <option @if(old('month')=="06") selected @endif value="6">Juni</option>
                                    <option @if(old('month')=="07") selected @endif value="7">Juli</option>
                                    <option @if(old('month')=="08") selected @endif value="8">Agustus</option>
                                    <option @if(old('month')=="09") selected @endif value="9">September</option>
                                    <option @if(old('month')=="10") selected @endif value="10">Oktober</option>
                                    <option @if(old('month')=="11") selected @endif value="11">November</option>
                                    <option @if(old('month')=="12") selected @endif value="12">Desember</option>       
                                </select>
                       </div>
                    </div>
                </div>
             <div class="form-group label-floating">
             <div class="row">
                <div class="col-md-2"><label class="control-label">Member Baru</label></div>
               <div class="col-md-10"> <select name="paket_baru" class="form-control">
                    <option value="0" selected>Semua</option>
                   @foreach($packageprice as $paket)
                        <option value="{{$paket->id}}">{{$paket->title}}</option>
                   @endforeach
                </select>
            </div>
            </div>
            </div>
            <div class="form-group label-floating">
            <div class="row">
                <div class="col-md-2"><label class="control-label">Member Perpanjangan</label></div>
                <div class="col-md-10"><select name="paket_perpanjang" class="form-control">
                     <option value="0" selected>Semua</option>
                   @foreach($packageprice as $paket)
                        <option value="{{$paket->id}}">{{$paket->title}}</option>
                   @endforeach
                </select>
            </div></div>
            </div>
            <div class="form-group label-floating">

                <div class="row"><div class="col-md-2"><label class="control-label">Member Expire</label></div>
               <div class="col-md-9"><input type="text" name="expire" class="form-control"></div><div class="col-md-1"><p>Hari</p></div></div>
            </div>
            <div class="form-group label-floating">
            <div class="row">
                <div class="col-md-2"><label class="control-label">Paket</label></div>
                <div class="col-md-10"><select name="paket" class="form-control">
                     <option value="0" selected>Semua</option>
                   @foreach($packageprice as $paket)
                        <option value="{{$paket->id}}">{{$paket->title}}</option>
                   @endforeach
                </select>
            </div></div>
            </div>
            <div class="form-group label-floating">
            <div class="col-md-2"></div>
            <input type="checkbox" name="harian" class="checkbox4">
                <label class="control-label">Member Gym Harian</label>
            </div>
            <div class="form-group label-floating">
            <div class="col-md-2"></div>
            <input type="checkbox" class="checkbox4" name="trial">
                <label class="control-label">Member Free Trial</label>
            </div>
             <div class="form-group label-floating">
             <div class="col-md-2"></div>
            <input type="checkbox" class="checkbox4" name="aktivasi">
                <label class="control-label">Member Belum Aktivasi</label>
            </div>
             <div class="form-group label-floating">
             <div class="row">
                <div class="col-md-2"><label class="control-label">Pernah Checkin</label></div>
                <div class="col-md-10"><select name="checks[]" class="select2" id="zona" multiple>
                        @foreach($gym as $gy)
                        <option value="{{$gy->id}}">{{$gy->title}}</option>
                   @endforeach
                    </select>
            </div></div>
            </div>
            <div class="form-group label-floating">
            <div class="row">
               <div class="col-md-2"> <label class="control-label">Kota</label></div>
                <div class="col-md-10"><select name="kota[]" class="form-control" id="zona">
                        @foreach($zona as $zone)
                            <option  value="{{$zone->id}}">{{$zone->title}}</option>
                        @endforeach
                    </select>
            </div></div>
            </div>
            <a href="/u/listemail" class="btn btn-white">Batal</a>
            <button type="submit" class="btn btn-info">Save</button>
        </form>
    </div>
</div>

@endsection