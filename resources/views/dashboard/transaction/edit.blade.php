@extends('dashboard._layout.dashboard')
@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('transaction-edit',$transaction)!!}
@endsection
@section('content')
<script type="text/javascript">
    function check(){
   /* var vall = $(e).attr('id');*/
    var vall= document.getElementById("promo").value;
    
     $.ajax({
      url: '/u/transactions/lookdiscount/'+vall,
      dataType: 'json',
      data: {
         format: 'json'
      },
      error: function() {
         $('#price').html('<p>Tentukan paketnya</p>');
      },

      success: function(data) {
         $('#alert').slideDown();
        console.log(data.price);
        if(vall == "0"){
            if(data.unit == "PERCENTAGE"){
                 $('#price').html("<label class='control-label'>Discount</label><input type='text' readonly='' class='form-control' name='discount' value='0'>")
            }else{
                 $('#price').html("<label class='control-label'>Discount</label><input type='text' readonly='' class='form-control' name='discount' value='0'>")
            }
            $('#unit').html("<label class='control-label'>Unit</label><input type='text' readonly='' class='form-control' name='unit' hidden='' value='Tidak Didefinsikan'>")
            document.getElementById("price_1").style.display="none";
            document.getElementById("unit_1").style.display="none";
        }else{
            if(data.unit == "PERCENTAGE"){
                 $('#price').html("<label class='control-label'>Discount</label><input type='text' readonly='' class='form-control' name='discount' value=' "+data.value+"'>")
            }else{
                 $('#price').html("<label class='control-label'>Discount</label><input type='text' readonly='' class='form-control' name='discount' value=' "+data.value+"'>")
            }
            $('#unit').html("<label class='control-label'>Unit</label><input type='text' readonly='' class='form-control' name='unit' hidden='' value=' "+data.unit+"'>")
            document.getElementById("price_1").style.display="none";
       }
        
        
            /*.append($title)*/
             $('#alert .close').click(function(e) {
               e.preventDefault();
              $(this).closest(' #alert').slideUp();
            });
      },
      type: 'GET'
   });
}
function nilaiTransaksi(){
    var vall= document.getElementById("valuepayment").value;
    console.log(vall);
    if(vall == "IPAYMU" || vall == "Transfer"){
        $('#transaksi').html("<label class='control-label'>Nomor Transaksi</label><input   type='text' required class='form-control' name='refrences_payment' value=''>");
                        
    }else{
        $('#transaksi').html("<label class='control-label'>Nomor Transaksi</label><input   type='text'readonly class='form-control' name='refrences_payment' value=''>");
    }
    document.getElementById("no_transaksi").style.display="none";
    document.getElementById("no_transaksi").style.display="none";
}
function Cash(){
    document.getElementById("cashs").readOnly="true";
}
</script>
<body onload="{{$transaction->payment_method}}()">
<form action="/u/transactions/{{ $transaction->id }}" method="POST">
    <div class="row">
        <div class="col-lg-6">
            
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}

                    <div class="form-group label-floating @if($errors->has('member')) has-error @endif">
                        <label class="control-label">Member</label>
                        <select  name="member" id="" class="select2 form-control">
                            @foreach($members as $member)
                                <option value="{{$member->id}}" @if(old('member',$transaction->member_id)==$member->id) selected @endif>{{$member->id}} - {{$member->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('member')) <p class="help-block">{{ $errors->first('member') }}</p> @endif
                    </div>                    

                    <div class="form-group label-floating @if($errors->has('gym')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select name="gym" id="" class="select2 form-control">
                            @foreach($gyms as $gym)
                                <option value="{{$gym->id}}" @if(old('gym',$transaction->gym_id)==$gym->id) selected @endif>{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym')) <p class="help-block">{{ $errors->first('gym') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('packages')) has-error @endif">
                        <label class="control-label">Paket</label>
                        <select name="packages" id="" class="select2 form-control">
                            @foreach($packages as $package)
                                <optgroup label="{{$package->title}}">
                                    @foreach($package->packagePrice()->get() as $packagePrice)
                                        <option value="{{$packagePrice->id}}" @if(old('packages',$transaction->package_price_id)==$packagePrice->id) selected @endif>{{$packagePrice->title}} - {{number_format($packagePrice->price)}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @if($errors->has('packages')) <p class="help-block">{{ $errors->first('packages') }}</p> @endif
                    </div>
                    
                    <div class="form-group label-floating @if($errors->has('promo')) has-error @endif">
                        <label class="control-label">Promo</label>
                        <select name="promo" id="promo" class="select2 form-control" onchange="check()">
                        <option selected="" value="0">Promo</option>
                            @foreach($promos as $promo)
                                
                                        <option value="{{$promo->id}}" @if(old('promo',$transaction->promo_id)==$promo->id) selected @endif>{{$promo->title}} - code {{$promo->code}}</option>
                                    
                            @endforeach
                        </select>
                    @if($errors->has('promo')) <p class="help-block">{{ $errors->first('promo') }}</p> @endif
                    </div>

                    <div class="form-group" id="price">
                        
                     </div>
                     <div class="form-group" id="unit">
                        
                     </div>

                     <div class="form-group" id="price_1">
                     <label class='control-label'>Discount</label>
                        <input type='text' readonly='' class='form-control' name='discount' value="{{$promo->value}}">
                     </div>

                     <div class="form-group" id="unit_1">
                     <label class='control-label'>Unit</label><input type='text' readonly='' class='form-control' name='unit' value="{{$promo->unit}}"></div>

                    <div  class="form-group label-floating @if($errors->has('payment')) has-error @endif">
                        <label class="control-label">Payment Method</label>
                        <select onchange="nilaiTransaksi()" id="valuepayment" name="payment" id="" class="select2 form-control">
                         <option @if(old('payment',$transaction->payment_method)=="") selected @endif value="" >Payment Method</option>
                            <option @if(old('payment',$transaction->payment_method)=="IPAYMU") selected @endif  value="IPAYMU">IPAYMU</option>
                            <option @if(old('payment',$transaction->payment_method)=="Transfer") selected @endif  value="Transfer">Transfer</option>
                            <option @if(old('payment',$transaction->payment_method)=="Cash") selected @endif value="Cash">Cash</option>
                        </select>
                        @if($errors->has('payment')) <p class="help-block">{{ $errors->first('payment') }}</p> @endif
                    </div>

                    <div class="form-group" id="no_transaksi">
                     <label class='control-label'>No Transaksi</label><input type='text' class='form-control' name='payment_method' id="cashs" value="{{$transaction->refrences_payment}}"></div>

                    <div id="transaksi" class="form-group label-floating @if($errors->has('transaksi')) has-error @endif">
                        @if($errors->has('transaksi')) <p class="help-block">{{ $errors->first('transaksi') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('status')) has-error @endif">
                        <label class="control-label">Status</label>
                        <select name="status" id="" class="select2 form-control">
                         <option value="Pending" selected="">Pending</option>
                        <option value="Active">Active</option>
                        </select>
                        @if($errors->has('status')) <p class="help-block">{{ $errors->first('status') }}</p> @endif
                    </div>

                    <div class="form-group text-right">
                        <a href="/u/overview" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            
        </div>
    </div>
    </form>
@endsection