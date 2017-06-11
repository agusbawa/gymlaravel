@extends('dashboard._layout.dashboard')

@section('help-title', 'Pendapatan member baru')
@section('title', 'Pendapatan member baru')
@section('page-title', 'Pendapatan Member Perpanjangan')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchpendapatanlong" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                                <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                                <!--<option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>-->
                                <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                                <!--<option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>-->
                                <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                                <!--<option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>-->
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
                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelpendapatanlong"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFpendapatanlong"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
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
            <th rowspan="2">Lokasi</th>
            <th colspan="5" class="text-center">Pendapatan Baru<br/>Rp {{$total}}<div class="persen" style="visibility:hidden;">@if($total )
                                            {{number_format(($total/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
           
           
        </tr>
        <tr class="text-center">
        <td>Jumlah </td>
        <td>Paket&nbsp;1&nbsp;Bulan <br/>Rp {{$satu}}<div class="persen" style="visibility:hidden;">@if($total && $satu)
                                            {{number_format(($satu/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;3&nbsp;Bulan <br/>Rp {{$dua}}<div class="persen" style="visibility:hidden;">@if($total && $dua)
                                            {{number_format(($dua/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;6&nbsp;Bulan <br/> Rp {{$tiga}}<div class="persen" style="visibility:hidden;">@if($total && $tiga)
                                            {{number_format(($tiga/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;12&nbsp;Bulan <br/> Rp {{$empat}} <div class="persen" style="visibility:hidden;">@if($total && $empat)
                                            {{number_format(($empat/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        
        </tr>
       
          <?php
        $date_awal = Carbon\Carbon::parse($backdate)->format('d-m-Y');
        $date_akhir = Carbon\Carbon::parse($currentdate)->format('d-m-Y');
        ?>
        @if($nama_gym==null)

        @else
@foreach ($gyms as $gymku)

              <?php
                $pendapatangym = App\Transaction::orderBy('transactions.id','asc')
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->join('members','members.id','=','transactions.member_id')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('gyms.zona_id','=',$gymku->id)
        ->where('member_histories.new_register',null)->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->get()
        ;
        
         $paketsatugym = App\Transaction::orderBy('transactions.id','asc')
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->join('members','members.id','=','transactions.member_id')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('gyms.zona_id','=',$gymku->id)
        ->where('member_histories.new_register',null)->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()
        ;
        $paketduagym = App\Transaction::orderBy('transactions.id','asc')
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->join('members','members.id','=','transactions.member_id')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('member_histories.new_register',null)->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('gyms.zona_id','=',$gymku->id)
        ->where('package_prices.day','=','90')
        ->get()
        ;
        
        $pakettigagym = App\Transaction::orderBy('transactions.id','asc')
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->join('members','members.id','=','transactions.member_id')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('member_histories.new_register',null)->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('gyms.zona_id','=',$gymku->id)
        ->where('package_prices.day','=','180')
        ->get()
        ;
        $paketpatgym = App\Transaction::orderBy('transactions.id','asc')
        ->join('package_prices','transactions.package_price_id','=','package_prices.id')
        ->join('members','members.id','=','transactions.member_id')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('member_histories.new_register',null)->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('gyms.zona_id','=',$gymku->id)
        ->where('package_prices.day','=','365')
        ->get()
        ;
            $totalgym = 0;
            $satugym = 0;
            $duagym = 0;
            $tigagym = 0;
            $empatgym = 0;
            foreach ($pendapatangym as $pendapatan => $hah) {
                $totalgym = $totalgym + $hah->total;
            }
            foreach ($paketsatugym as $pendapatan => $hah) {
                $satugym = $satugym + $hah->total;
            }
              foreach ($paketduagym as $pendapatan => $hah) {
                $duagym = $duagym + $hah->total;
            }
            
            foreach ($pakettigagym as $pendapatan => $hah) {
                $tigagym = $tigagym + $hah->total;
            }
            foreach ($paketpatgym as $pendapatan => $hah) {
                $empatgym = $empatgym + $hah->total;
            }
              ?>
            </a>
          </h4>
        </div>
       <tr>
            <td>{{$gymku->title}}</td>
            <td>{{$totalgym}}<div class="persen" style="visibility:hidden;">@if($total && $totalgym)
                                            {{number_format(($totalgym/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
            <td>{{$satugym}}<div class="persen" style="visibility:hidden;">@if($totalgym && $satugym)
                                            {{number_format(($satugym/$totalgym)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
            <td>{{$duagym}}<div class="persen" style="visibility:hidden;">@if($totalgym && $duagym)
                                            {{number_format(($duagym/$totalgym)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
            <td>{{$tigagym}}<div class="persen" style="visibility:hidden;">@if($totalgym && $tigagym)
                                            {{number_format(($tigagym/$totalgym)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
            <td>{{$empatgym}}<div class="persen" style="visibility:hidden;">@if($empatgym && $totalgym)
                                            {{number_format(($empatgym/$totalgym)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
           </tr>
            </a>
          </h4>
        </div>
   <script type="text/javascript">
    var checkbox = $(".checkboxId");
    checkbox.change(function(event) {
        var checkbox = event.target;
        if (checkbox.checked) {
            document.getElementById("hidden_persen1{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen2{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen3{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen4{{$gymku->id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen5{{$gymku->id}}").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen4{{$gymku->id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen5{{$gymku->id}}").style.visibility = "hidden";  
        }
    });
</script>
                @endforeach

              @endif
              </table>
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