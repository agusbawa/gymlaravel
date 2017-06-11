@extends('dashboard._layout.dashboard')

@section('title', 'Member '.$member->title)
@section('page-title', 'Member '.$member->title)
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-extend',$member)!!}
@endsection
@section('content')

<div class="m-b-15"></div>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Informasi Personal</b></h4>
            <div class="p-20">
                <div class="about-info-p">
                    <strong>Nama Lengkap</strong>
                    <br>
                    <p class="text-muted">{{$member->name}} ({{$member->nick_name}})</p>
                </div>
                 <div class="about-info-p">
                    <strong>Expire</strong>
                    <br>
                    <p class="text-muted">{{$member->expired_at}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Jenis Kelamin</strong>
                    <br>
                    <p class="text-muted">{{($member->gender=="FEMALE")?"Wanita":"Pria"}}</p>
                </div>
                <div class="about-info-p">
                    <strong>No Telp</strong>
                    <br>
                    <p class="text-muted">{{$member->phone}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Email</strong>
                    <br>
                    <p class="text-muted">{{$member->email}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Hobi</strong>
                    <br>
                    <p class="text-muted">{{$member->hobby}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Pekerjaan</strong>
                    <br>
                    <p class="text-muted">{{$member->job}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Gym</strong>
                    <br>
                    <p class="text-muted">{{$member->gym->title}}</p>
                </div>
                

               
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-8">
       <form action="/u/members/extend/{{$member->id}}" method="POST">
    <div class="row">
        <div class="col-lg-6">
            
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group label-floating @if($errors->has('member')) has-error @endif">
                        <label class="control-label">Member Id</label>
                            <input class="form-control" type="text" name="member" value="{{$member->id}}" readonly="">
                    </div>                    

                    <div class="form-group label-floating @if($errors->has('gym')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select name="gym" onchange="gy(this)" id="idgym" class="select2 form-control">
                        @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                    <option @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                        @else
                            @foreach($gyms as $gym)
                                <option value="{{$gym->id}}" @if($gym->id == $member->gym_id) selected @endif>{{$gym->title}}</option>
                            @endforeach
                        @endif
                        </select>
                        @if($errors->has('gym')) <p class="help-block">{{ $errors->first('gym') }}</p> @endif
                    </div>

                   
                     <div class="form-group label-floating @if($errors->has('paket')) has-error @endif">
                        <label class="control-label">Paket</label>
                        <select class="form-control select2" onchange="pack(this)" id="pak" name="paket">
                            <option value="" selected>Paket</option>
                              
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

                    <div class="form-group" id="price">
                        
                     </div>
                     <div class="form-group" id="unit">
                        
                     </div>

                    <div  class="form-group label-floating @if($errors->has('payment')) has-error @endif">
                        <label class="control-label">Payment Method</label>
                        <select onchange="change()"  id="metode" name="payment" id="" class="select2 form-control">
                         <option value="" selected="">Payment Method</option>
                            <option value="CASH">Cash</option>
                            <option value="EDC">EDC</option>
                            <option value="Lain">Lain-lain</option>
                        </select>
                        @if($errors->has('payment')) <p class="help-block">{{ $errors->first('payment') }}</p> @endif
                    </div>

                
                    <div class="form-group" id="keterangan" label-floating @if($errors->has('metode')) has-error @endif">           
                    <label class='control-label'>Keterangan</label><input type='text' name='transaksi' class='form-control' value=''>
                        @if($errors->has('transaksi')) <p class="help-block">{{ $errors->first('transaksi') }}</p> @endif
                    </div>
                    <script>
                        function tampil(){
                                   var x = document.getElementById("metode");
                                   $("#keterangan").show();
                                   console.log('hai');
                                   if(x.value=="CASH" || x.value=="" ){
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

                    <div class="form-group text-right">
                        <a href="/u/members/extend" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            
        </div>
    </div>
    </div>
    </form>
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Invoice</th>
                             
                             <th>Total</th>
                        </tr>   
                    </thead>
                    <tbody>
                    @foreach($transaksis as $transaksi)
                    <tr>
                        <td>{{$transaksi->created_at}}</td>
                        <td>{{$transaksi->code}}</td>
                        <td>Rp {{number_format($transaksi->total)}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    {{$transaksis->links()}}
</div>
@endsection