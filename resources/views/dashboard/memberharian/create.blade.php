@extends('dashboard._layout.dashboard')
@section('title', 'Tambah Member Harian')
@section('page-title', 'Tambah Member Harian')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('memberharian-create')!!}
@endsection
@section('content')
<script type="text/javascript">
    function check(){
   /* var vall = $(e).attr('id');*/
    var vall= document.getElementById("pak").value;
    
     $.ajax({
      url: '/u/gymharian/lookprice/'+vall,
      dataType: 'json',
      data: {
         format: 'json'
      },
      error: function() {
         $('#price').html('<p>Tentukan paketnya</p>');
      },

      success: function(data) {
        console.log(data.price);
        $('#alert').slideDown();
         $('#price').html("<label class='control-label'>Harga</label><input type='text' readonly='' class='form-control' value='Rp "+parseFloat(data.price).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")+"'>")
            /*.append($title)*/
             $('#alert .close').click(function(e) {
               e.preventDefault();
              $(this).closest(' #alert').slideUp();
            });
      },
      type: 'GET'
   });
}

</script>

    <div class="row">
        <div class="col-lg-6">
            <form action="/u/gymharian" method="POST">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('nick_name')) has-error @endif">
                        <label class="control-label">Pangilan</label>
                        <input type="text" class="form-control" name="nick_name" value="{{old('nick_name')}}">
                        @if($errors->has('nick_name')) <p class="help-block">{{ $errors->first('nick_name') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('telp')) has-error @endif">
                        <label class="control-label">Telp.</label>
                        <input type="text" class="form-control" name="telp" value="{{old('telp')}}">
                        @if($errors->has('telp')) <p class="help-block">{{ $errors->first('telp') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                        <label class="control-label">Email.</label>
                        <input type="text" class="form-control" name="email" value="{{old('email')}}">
                        @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control select2" id="gym_id" onchange="gy(this)" name="gym_id">
                           
                            @if(\App\Permission::CheckGym(Auth::user()->id)==1)
                                @foreach($gyms as $gym)
                                @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==0)
                                    @continue
                                @endif
                                 
                                    <option  @if(old('gym_id')==$gym->id) selected @endif @if(\App\Permission::GymAccess(Auth::user()->id,$gym->id)==1) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @else
                              <option value="" selected>Gym</option>
                                @foreach($gyms as $gym)
                                    <option @if(old('gym_id')==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('package')) has-error @endif">
                        <label class="control-label">Package</label>
                        <select class="form-control select2" onchange="check()" id="pak" name="package">
                            <option value="">Harga</option>
                            
                        </select>
                        @if($errors->has('package')) <p class="help-block">{{ $errors->first('package') }}</p> @endif
                    </div>
                    <script>
    var global;
   
    function gy(e){
        var paket = e.value
        console.log(paket)
        if(paket != ""){
   
        $("#pak").empty();
        $.ajax({
            url:'/u/getpaketharian/'+paket,
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
     
       var selected = $("#gym_id").val();
       console.log(selected);
       if($("#idgym").val() != null || $("#idgym").val() != ""){
             
                $.ajax({
            url:'/u/getpaketharian/'+selected,
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
                     <div class="form-group label-floating @if($errors->has('metode')) has-error @endif">
                        <label class="control-label">Metode Pembayaran</label>
                        <select class="form-control" name="metode" onchange="change()" id="metode">
                            <option @if(old('metode')=="CASH") selected @endif value="CASH">Cash</option>
                            <option @if(old('metode')=="EDC") selected @endif value="EDC">EDC</option>
                            <option @if(old('metode')=="lain") selected @endif value="lain">Lain - Lain</option>
                        </select>
                        @if($errors->has('keterangan')) <p class="help-block">{{ $errors->first('keterangan') }}</p> @endif
                    </div>
                    <div class="form-group" ></div>
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
                                    exefirst();
                                });
                    </script>
                     <div class="form-group label-floating @if($errors->has('tgl_bayar')) has-error @endif">
                        <label class="control-label">Tanggal Bayar</label>
                        <input @if(\App\User::where('id',Auth::user()->id)->where('tanggal','0')->count() == 1) readonly="true" class="form-control" @else  class="form-control datepicker"  @endif type="text" name="tgl_bayar" value="{{old('tgl_bayar',date('d-m-Y'))}}">
                        @if($errors->has('tgl_bayar')) <p class="help-block">{{ $errors->first('tgl_bayar') }}</p> @endif
                    </div>   
                     
                    <div class="form-group text-right">
                        <a href="/u/gymharian" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection