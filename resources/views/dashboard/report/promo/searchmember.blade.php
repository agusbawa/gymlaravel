@extends('dashboard._layout.dashboard')

@section('help-title', 'Promo')
@section('title', 'Promo')
@section('page-title', 'Promo')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchpromo" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                            <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                            <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                            <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                            <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                            <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>
                        </select>
                    </div>   
                    <div class="form-group">
                    <label class="control-label">Periode</label>
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>
                    <div class="form-group checkbox">
                        <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                        <label for="checkbox0">
                            Tampilkan %
                        </label>
                    </div>
                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelpromo"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFpromo"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>

                    <div id="hidden_gym" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Gym</label>
                                <select name="gyms[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Gym">
                                    @foreach($gym as $gymku)
                                        <option @if(in_array($gymku->id, $tertentugym) == $tertentugym)) selected @endif value="{{$gymku->id}}">{{$gymku->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div id="hidden_zona" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Zona</label>
                                <select name="zonasku[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
                                    @foreach($zona as $zonaku)
                                        <option @if(in_array($zonaku->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zonaku->id}}">{{$zonaku->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div id="hidden_zona1" style="display: none;">
                        <div style="margin-top: 10px;">
                            <label for="">Nama Zona</label>
                                <select name="zonas[]" id="zonaku" class="select2 form-control" placeholder="Silakan Pilih Nama Zona">
                                    <option value="0" selected>Pilih Zona</option>
                                    @foreach($zona as $zona)
                                        <option @if(in_array($zona->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zona->id}}">{{$zona->title}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>

                    <div class="form-group label-floating" id="hidden_zonagym" style="display: none;">
                        <label class="control-label">Nama Gym</label>
                            <select name="gymku[]" multiple="multiple" class="select2" id="gym">     
                            </select>
                    </div>
                     
                    <div class="" style="margin-top: 10px;">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                    </div>

                </form>
                
            </div>
        </div>
        <br/>
<div class="panel panel-default table-responsive" style="text-align:center; overflow:auto;" >
        <table class="table table-bordered" >
            <tr>
                <th>Lokasi</th>
                <th>Member yang Bergabung <br/>{{$totalmembers}}</th>
                <th>Non Promo <br/>{{$totalnonpromos}}</th>
                <th>Promo <br/>{{$totalpromos}}</th>
            </tr>

@foreach($gyms as $gymku)
<?php
$totalmembers = 0;
        $totalnonpromos = 0;
        $totalpromos = 0;
        $totalmemberbaru = 0;
        $totalmemberpanjang = 0;
  $members = App\Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.gym_id','=',$gymku->id)
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->value('transactions.total');
        $nonpromos = App\Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.gym_id','=',$gymku->id)
                        ->where('transactions.promo_id','=','0')
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->value('transactions.total');
                
        $promos = App\Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.gym_id','=',$gymku->id)
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->value('transactions.total');
        $member_baru = App\Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.gym_id','=',$gymku->id)
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','!=',null)
                        ->value('transactions.total');
        $member_panjang = App\Transaction::orderBy('transactions.id','DESC')
                        ->join('members','members.id','=','transactions.member_id')
                        ->where('transactions.gym_id','=',$gymku->id)
                        ->whereBetween('members.created_at',[$backdate,$currentdate])
                        ->where('transactions.promo_id','!=','0')
                        ->join('member_histories','members.id','=','member_histories.member_id')
                        ->where('member_histories.new_register','=',null)
                        ->value('transactions.total');
                        
        $totalmembers = $totalmembers + $members;
        $totalnonpromos = $totalnonpromos + $nonpromos;
        $totalpromo = $totalpromos + $promos;
        $totalmemberbaru = $totalmemberbaru + $member_baru;
       $totalmemberpanjang = $totalmemberpanjang + $member_panjang;
?>

            <tr>
                <td>{{$gymku->title}}</td>
                <td>{{$totalmembers}}</td>
                <td>{{$totalnonpromos}}</td>
                <td>{{$totalpromos}}</td>
            </tr>
        </table>
</div>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gymku->id}}" aria-expanded="true" aria-controls="collapseOne">
              
            </a>
          </h4>
        </div>
        <div id="{{$gymku->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
          <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b></b></h3>
                                        <p class="text-muted"><span id="hidden_persen1{{$gymku->id}}" style="visibility: hidden;">0%</span><br>Member yang Bergabung</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-ban-circle text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b></b></h3>
                                        <p class="text-muted"><span id="hidden_persen2{{$gymku->id}}" style="visibility: hidden;">0%</span><br>Non Promo</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-ok-circle text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b></b></h3>
                                        <p class="text-muted"><span id="hidden_persen3{{$gymku->id}}" style="visibility: hidden;">0%</span><br>Promo</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                  </div>
                </div>
    <script type="text/javascript">
    var checkbox = $(".checkboxId");
    checkbox.change(function(event) {
        var checkbox = event.target;
        if (checkbox.checked) {
            document.getElementById("hidden_persen1{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen2{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen3{{$gymku->id}}").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen{{$gymku->id}}3").style.visibility = "hidden"; 
        }
    });
</script>
@endforeach
</div>
<div class="col-lg-6">
  <div class="card-box">
      <h4 class="m-t-0 header-title"><b>Pie Chart</b></h4>
                                    <canvas id="skills" width="300" height="300"></canvas>
                </div>
              </div>
<div class="col-lg-6">
  <div class="card-box">
      <h4 class="m-t-0 header-title"><b>Bar Chart</b></h4>
                                    <canvas id="bar" width="300" height="300"></canvas>
                </div>
              </div>

<script>
 var pieData = [
   {
      value: {{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->get()->count()}},
      label: 'All Member',
      color: '#811BD6'
   },
   {
      value: {{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
         ->where('package_prices.day','=','30')
         ->get()->count()}},
      label: 'Paket 1 Bulan',
      color: '#8C9BD6'
   },
  
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }

         var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData,options);
var barData ={
    labels: ["All Member","Paket 1 Bulan"],
    datasets: 
    [
        {
            label: "Report",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                 'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1,
            data: [{{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->get()->count()}},{{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->get()->count()}}],
        }
    ]
}
         var context = document.getElementById('bar').getContext('2d');
         var skillsChart = new Chart(context).Bar(barData);
</script>
<script type="text/javascript">
    function showDiv(select){
        if(select.value==3){
            document.getElementById("hidden_gym").style.display = "block"; 
            document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none";
       }else if(select.value==4){ 
            document.getElementById("hidden_zona").style.display = "block";
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none"; 
       }else if(select.value==5){
            document.getElementById("hidden_zona1").style.display = "block";
            document.getElementById("hidden_zonagym").style.display = "block"; 
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona").style.display = "none"; 
       }else{
            document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_gym").style.display = "none"; 
            document.getElementById("hidden_zona1").style.display = "none";
            document.getElementById("hidden_zonagym").style.display = "none";
       }
    } 
</script>
<script>
    $(function(){
    // turn the element to select2 select style
        $('#zonaku').change(function(){
            var countryID = $(this).val();  
            console.log(countryID);  
            if(countryID){
                $.ajax({
                   type:"GET",
                   url:"{{url('gym-zona')}}?zona_id="+countryID,
                   success:function(res){               
                    if(res){
                        $("#gym").empty();
                        $.each(res,function(key,value){
                            $("#gym").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#gym").empty();
                    }
                   }
                });
            }else{
                 $.ajax({
                   type:"GET",
                   url:"{{url('gym-zona')}}?zona_id=",
                   success:function(res){               
                    if(res){
                        $("#gym").empty();
                        $("#gym").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#gym").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#gym").empty();
                    }
                   }
                });
            }      
        });
    });
</script>
@endsection