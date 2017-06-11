@extends('dashboard._layout.dashboard')
@section('title', 'Aktivasi Member')
@section('page-title', 'Aktivasi Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-aktifasi')!!}
@endsection
@section('content')

<div class="row">
    
   
    <div class="col-lg-12">
             <div class="card-box">
            
                <table class="table table-table-striped">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Promo</th>
                        <th>Paket</th>
                        <th>Total </th>
                        
                        <th>Tipe Aktivasi </th>
                    </tr>
                    <tr>
                </thead>
                <tbody>
               
                <tr>
               
                    <td>{{$transaksis->code}}</td>
                    <td>@if($transaksis->promo_id==0) Tidak ada @else {{$transaksis->promo->title}} @endif</td>
                    <td>@if($transaksis->packageprice == null) Kosong @else{{$transaksis->packageprice->title}}@endif</td>
                    <td>Rp {{number_format($transaksis->total)}}</td>
                    
                   
                    <td>@if($transaction->type=="New")<span class="label label-purple">{{$transaction->type}}</span> @else <span class="label label-info">Perpanjang</span> @endif</td>
                    
                </tr>
                
                </tbody>
                </table>
             </div>
        </div>
         <div class="col-lg-6">
        <div class="col-lg-12">
            <form action="/u/ubahtransaksi/{{$transaction->id}}" method="POST">
                {{ csrf_field() }}
                 {{ method_field('PATCH') }}
                    <div class="card-box">
                   
                     <div class="form-group label-floating @if($errors->has('paket')) has-error @endif">
                        <label class="control-label">Paket</label>
                        <select class="form-control select2" id="paket2" onchange="pack(this)" name="paket">
                            <option value="" selected>Paket</option>
                                @foreach($paket as $paket)
                                <option @if(old('paket',$transaction->package_price_id)==$paket->id) selected @endif value="{{$paket->id}}">{{$paket->title}}</option>
                            @endforeach
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
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div> 
            

                    <div class="form-group" id="price"></div>
                     <div class="form-group label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Metode Pembayaran</label>
                        <select class="form-control" name="payment" onchange="change()" id="metode">
                            <option value="Cash">Cash</option>
                            <option value="EDC">EDC</option>
                            <option value="lain">Lain - Lain</option>
                        </select>
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div>
                   
                    <div class="form-group" id="bayar" label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Bayar</label>
                        <input type="text" class="form-control" name="bayar">
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
                                   console.log('hai');
                                   if(x.value=="Cash"  ){
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
                                   if(x.value=="Cash"  ){
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
                               
                    </script>
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-white btn-custom waves-effect">Batal</button>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        
    </div>
        <div class="col-md-6">
            <div class="card-box">
            <button onclick="editform()" class="pull-right btn btn-default btn-sm waves-effect waves-light">Edit</button>
            <h4 class="m-t-0 header-title"><b>Informasi Personal</b></h4>
            <form action="/u/updateak/{{$member->id}}" method="POST">
            {{ method_field('PATCH') }}
                    {{ csrf_field() }}
            <div class="p-20">
                <div class="about-info-p">
                    <strong>Nama Lengkap</strong>
                    <br>
                     <p class="text-muted textshow">{{$member->name}} ({{$member->nick_name}})</p>  
                    <div class="form-group formhide">
                        <input type="text" class="form-control" value="{{$member->name}}" name="name">
                    </div>
                   
                </div>
                <div class="about-info-p">
                    <strong>Jenis Kelamin</strong>
                    <br>
                    <div class="form-group formhide">
                       <div class="radio radio-pink radio-inline">
                            <input type="radio" name="gender" id="female" value="FEMALE" @if(old('gender',$member->gender)=="FEMALE" || old('gender')=="") checked @endif>
                            <label for="female">
                                Perempuan
                            </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="gender" id="male" value="MALE"  @if(old('gender',$member->gender)=="MALE") checked @endif>
                            <label for="male">
                                Laki-laki
                            </label>
                        </div>
                    </div>
                    <p class="text-muted textshow">{{($member->gender=="FEMALE")?"Perempuan":"Laki-laki"}}</p>
                </div>
                <div class="about-info-p ">
                    <strong>No Telp</strong>
                    <br>
                     
                    <div class="form-group formhide">
                        <input type="text" class="form-control" value="{{$member->phone}}" name="phone">
                    </div>
                    <p class="text-muted textshow">{{$member->phone}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Email</strong>
                    <br>
                    <div class="form-group formhide">
                        <input type="text" class="form-control" value="{{$member->email}}" name="email">
                    </div>
                    <p class="text-muted textshow">{{$member->email}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Hobi</strong>
                    <br>
                    <div class="form-group formhide">
                        <input type="text" class="form-control" value="{{$member->hobby}}" name="hobby">
                    </div>
                    <p class="text-muted textshow">{{$member->hobby}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Pekerjaan</strong>
                    <br>
                    <div class="form-group formhide">
                        <input type="text" class="form-control" value="{{$member->job}}" name="job">
                    </div>
                    <p class="text-muted textshow">{{$member->job}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Gym</strong>
                    <br>
                    <div class="form-group formhide">
                        <select class="form-control" name="gym_id">
                         @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                    <option @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                        @else
                            @foreach($gyms as $gym)
                                <option @if($gym->id == $member->gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        @endif
                        </select>
                        
                    </div>
                    <p class="text-muted textshow">{{$member->gym->title}}</p>
                </div>
             <div class="form-group formhide">
                       <button type="reset" onclick="editform()" class="btn btn-light  btn-sm waves-effect waves-light formhide"> Batal </button>
                       <button type="submit" value="1" class="btn btn-default  btn-sm waves-effect waves-light formhide"> Simpan </button>
                    </div>
            </div>
            </form>
        </div>
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
<script>
    $(document).ready(function(){
        $('.formhide').hide();
        $('.textshow').show();
          tampil();
       
        var paket2 = document.getElementById('paket2');
        pack(paket2);
    });
    function editform(){
        $('.formhide').toggle();
        $('.textshow').toggle();
    }

</script>

<div class="col-lg-12">
<div class="card-box">
<form action="/u/members/activate/{{$transaction->id}}" method="POST">
{{ csrf_field() }}
    @if($transaction->type == "NEW" || $member->card == 0)            
                                    <div  class="form-group card label-floating @if($errors->has('card')) has-error @endif">
                                            <lable class="form-lable"> No Kartu </lable>
                                            <input type="text" class="form-control" name="card" value="{{old('card')}}">
                                            @if($errors->has('card')) <p class="help-block">{{ $errors->first('card') }}</p> @endif
                                            <div class="form-group text-right">
                                        </div>
                                   
   @endif     
<a href="/u/members" class="btn btn-white btn-custom waves-effect">Batal</a>
<button type="submit"  value="1" class="btn btn-pink waves-effect waves-light">Aktifkan</button>
                        
</form>
 
                </div>
                
           
</div>

@endsection