@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Member')
@section('page-title', 'Tambah Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-create')!!}
@endsection
@section('content')
<form action="/u/members" method="POST" accept-charset="UTF-8" enctype="multipart/form-data"   
    <div class="row">
        <div class="col-lg-12">
            
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>

                    <div id="slug" class="collapse @if((old('slugcheck'))) in @endif">
                        <div class="form-group label-floating @if($errors->has('slug')) has-error @endif">
                            <label class="control-label">ID Member Lama</label>
                            <input type="text" class="form-control" name="slug" value="{{old('slug')}}">
                            @if($errors->has('slug')) <p class="help-block">{{ $errors->first('slug') }}</p> @endif
                        </div>  
                    </div>


                    <div class="form-group label-floating @if($errors->has('nick_name')) has-error @endif">
                        <label class="control-label">Nama Panggilan</label>
                        <input type="text" class="form-control" name="nick_name" value="{{old('nick_name')}}">
                        @if($errors->has('nick_name')) <p class="help-block">{{ $errors->first('nick_name') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('gender')) has-error @endif">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="clearfix"></div>
                        <div class="radio radio-pink radio-inline">
                            <input type="radio" name="gender" id="female" value="FEMALE" @if(old('gender')=="FEMALE" || old('gender')=="") checked @endif>
                            <label for="female">
                                Perempuan
                            </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="gender" id="male" value="MALE"  @if(old('gender')=="MALE") checked @endif>
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
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="place_of_birth" value="{{old('place_of_birth')}}">
                                @if($errors->has('place_of_birth')) <p class="help-block">{{ $errors->first('place_of_birth') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating @if($errors->has('date_of_birth')) has-error @endif">
                                <label class="control-label">&nbsp;</label>
                                <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir (tanggal/bulan/tahun)" name="date_of_birth" value="{{old('date_of_birth')}}">
                                @if($errors->has('date_of_birth')) <p class="help-block">{{ $errors->first('date_of_birth') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('address_street') || $errors->has('address_region') || $errors->has('address_city')) has-error @endif">
                        <label class="control-label">Alamat</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Jalan" name="address_street" value="{{old('address_street')}}">
                                @if($errors->has('address_street')) <p class="help-block">{{ $errors->first('address_street') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kabupaten" name="address_region" value="{{old('address_region')}}">
                                @if($errors->has('address_region')) <p class="help-block">{{ $errors->first('address_region') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kota" name="address_city" value="{{old('address_city')}}">
                                @if($errors->has('address_city')) <p class="help-block">{{ $errors->first('address_city') }}</p> @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group label-floating @if($errors->has('phone')) has-error @endif">
                        <label class="control-label">No Telepon</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                        @if($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}">
                        @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('facebook_url') || $errors->has('twitter_url') || $errors->has('instagram_url')) has-error @endif">
                        <label class="control-label">Sosial Media</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="facebook_url" value="{{old('facebook_url')}}" placeholder="Link Facebook">
                                @if($errors->has('facebook_url')) <p class="help-block">{{ $errors->first('facebook_url') }}</p> @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="twitter_url" value="{{old('twitter_url')}}" placeholder="Link Twitter">
                                @if($errors->has('twitter_url')) <p class="help-block">{{ $errors->first('twitter_url') }}</p> @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="instagram_url" value="{{old('instagram_url')}}" placeholder="Link Instagram">
                                @if($errors->has('instagram_url')) <p class="help-block">{{ $errors->first('instagram_url') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('hobby')) has-error @endif">
                        <label class="control-label">Hobi</label>
                        <input type="text" class="form-control" name="hobby" value="{{old('hobby')}}">
                        @if($errors->has('hobby')) <p class="help-block">{{ $errors->first('hobby') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('job')) has-error @endif">
                        <label class="control-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="job" value="{{old('job')}}">
                        @if($errors->has('job')) <p class="help-block">{{ $errors->first('job') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('foto')) has-error @endif">
                        <label class="control-label">Foto</label>
                        <input type="file" class="form-control" name="foto">
                        @if($errors->has('foto')) <p class="help-block">{{ $errors->first('foto') }}</p> @endif
                    </div>

                    
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control select2" onchange="gy(this)" id="idgym" name="gym_id">
                            <option value="">Gym Member Mendaftar</option>
                            @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                    <option @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @else
                                @foreach($gyms as $gym)
                                    <option @if(old('gym_id')==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                     <div class="form-group label-floating @if($errors->has('paket')) has-error @endif">
                        <label class="control-label">Paket</label>
                        <select class="form-control select2" onchange="pack(this)" id="pak" name="paket">
                            <option value="" selected>pilih</option>
                               
                        </select>
                        @if($errors->has('paket')) <p class="help-block">{{ $errors->first('paket') }}</p> @endif
                    </div> 
                    <div class="form-group label-floating @if($errors->has('promo')) has-error @endif">
                        <label class="control-label">Promo</label>
                        <select class="form-control select2" id="pro" onchange="prom(this)" name="promo">
                        <option selected value="">pilih</option>
                        </select>
                        @if($errors->has('promo')) <p class="help-block">{{ $errors->first('promo') }}</p> @endif
                    </div>
                     <div class="form-group" id="total" label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Harga Total</label>
                        <input type="text" disabled class="form-control" id="hargatotal" name="keterangan">
                        @if($errors->has('<keter></keter>angan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div> 
            
<script>
    var global;
   function gy(e){
        var paket = e.value
     
        if(paket != ""){
   
        $("#pak").empty();
        $("#pro").empty();
        $.ajax({
            url:'/u/getpaket/'+paket,
            dataType:'json',
            data: {
                format: 'json'
            },
            error: function() {
            global = null;
            $('#hargatotal').val('0');
            },
            success: function(data) {
                 $('#hargatotal').val('0');
                if(data){
                        $('#pak').empty();
                        $('#pak').append('<option value="">pilih</option>');
                        $.each(data.paket,function(id,title){
                            $('#pak').append('<option value="'+id+'">'+title+'</option>');
                        });
                       
                    }else{
                       $("#pak").empty();
                    }

                 $('#pak').select2({
                    placeholder: "pilih"
                 });
                 
                $('#pro').select2({
                    placeholder: "pilih"
                });

            }
        });
        }else{
           $('#pak').empty();
           $('#pak').val(null).trigger("change");
           $('#pak').append('<option selected value="">pilih</option>');
        }
    }
    function pack(e){

        var paket = e.value
        $("#pro").empty();
         
        $.ajax({

            url: '/u/getpromo/'+paket,
            dataType: 'json',
            data: {
                format: 'json'
            },
            error: function() {
            global = null;
            $('#hargatotal').val('0');
            },
            success: function(data) {
                
                if(data){
                        $('#pro').empty();
                        $('#pro').append('<option selected value="">pilih</option>');
                        $.each(data.promo,function(id,title){
                            $('#pro').append('<option value="'+id+'">'+title+'</option>');
                        });
                    }else{
                       $("#pro").empty();
                    }

                    $('#pro').select2({
                      placeholder: "pilih"
                    });

                    global = data.paket.price
        var num = parseFloat(global).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $('#hargatotal').val(num);
            }
        });
    }
    function prom(e){
        var paket = e.value
        console.log(paket)
        $.ajax({
            url: '/u/transactions/lookdiscount/'+paket,
            dataType: 'json',
            data: {
                format: 'json'
            },
            error: function() {
                if(global != null){
                    $('#hargatotal').val(global);
                }else{
                    $('#hargatotal').val('0');
                }
            },
            success: function(data) {
                var lasvalue = $('#hargatotal').val();
                if(data.unit == "NOMINAL"){
                    var total = global - data.value;
                }else{
                    var total = global - (global * (data.value/100));
                }
                
                    var num = parseFloat(total).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                $('#hargatotal').val(num);
            }
        });
    }
     function exefirst(){
     
       var selected = $("#idgym").val();
       if($("#idgym").val() != null || $("#idgym").val() != ""){
             
                $.ajax({
            url:'/u/getpaket/'+selected,
            dataType:'json',
            data: {
                format: 'json'
            },
            error: function() {
            global = null;
            $('#hargatotal').val('0');
            },
            success: function(data) {
                if(data){
                        $('#pak').empty();
                        $('#pak').append('<option value="">pilih</option>');
                        $.each(data.paket,function(id,title){
                            $('#pak').append('<option value="'+id+'">'+title+'</option>');
                        });
                        
                    }else{
                       $("#pak").empty();
                    }
                   
            }
        });
             }
    }
</script>
                    <div class="form-group" id="price"></div>
                     <div class="form-group label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode" onchange="change()" id="metode">
                            <option value="CASH">Cash</option>
                            <option value="EDC">EDC</option>
                            <option value="lain">Lain - Lain</option>
                        </select>
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div>
                   
                     <div class="form-group" id="keterangan" label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan">
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div>
                    <script>
                        function tampil(){
                                   var x = document.getElementById("metode");
                                   $("#keterangan").show();
                                   if(x.value=="CASH"  ){
                                    $("#bayar").show();
                                    $("#keterangan").hide();
                                   }else{
                                    $("#bayar").hide();
                                    $("#keterangan").show();  
                                   }
                                  
                                }
                        function change(){
                                var x = document.getElementById("metode");
                                   $("#keterangan").show();
                                   console.log('hai');
                                   if(x.value=="CASH"  ){
                                    $("#bayar").show();
                                    $("#keterangan").hide();
                                   }else if(x.value=="EDC"  ){
                                    $("#bayar").show();
                                    $("#keterangan").show();
                                   }else{
                                    $("#bayar").show();
                                    $("#keterangan").show();  
                                   }
                        }
                                $(document).ready(function(){
                                    tampil();
                                    exefirst();
                                });
                    </script>
                    <div class="form-group label-floating @if($errors->has('card')) has-error @endif">
                        <label class="control-label">No Kartu</label>
                        <input type="text" class="form-control" name="card" value="{{old('card')}}">
                    @if($errors->has('card')) <p class="help-block">{{ $errors->first('card') }}</p> @endif
                    </div>
                 </div>
            </div>
                    <div class="row">
        <div class="col-lg-12">
            
                @foreach($vote as $vtK => $vtV)
                <div class="col-lg-6">
               
                <h3 class="text-left">{{$vtV->title}}</h3>
                <div class="well" style="max-height: 300px;overflow: auto;">
                    <ul class="list-group">
                     <div class="form-group label-floating @if($errors->has('vote_select,[]')) has-error @endif checkbox checkbox-primary">
                        @foreach($vtV->voteItems as $itK => $itV)
                        <li class="list-group-item" style="padding:1.5% 5%">
                         <input @if(old('vote_select[$itV->id]')==1) checked @endif name="vote_select[{{$itV->id}}]" value="1" id="checkbox2" type="checkbox">
                            <label>
                                {{$itV->description}}
                            </label>
                        </li>
                                     
                        @endforeach
                    </div>
                             
                    </ul>
                </div>
               
               </div>
               @if($errors->has('vote_select[]')) <p class="help-block">{{ $errors->first('vote_select[]') }}</p> @endif
                @endforeach
                 
            
        </div>
    </div>
                    <div class="form-group text-right">
                        <input type="hidden" name="registerfrom" value="0" />
                        <a href="/u/members" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
        </div>
    </div>

    
</form>
@endsection