    @extends('dashboard._layout.dashboard')

@section('help-title', 'Member')
@section('title', 'Member')
@section('page-title', 'Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('filter')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchmember" class="form-inline" method="POST">
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
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range_1')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>

                    <div class="form-group checkbox">
                        <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                        <label for="checkbox0">
                            Tampilkan %
                        </label>
                    </div>

                    @if($nama_gym==5)
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMember/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMember/search?lokasi={{$nama_gym}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                    @else
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMember/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMember/search?lokasi={{$nama_gym}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                    @endif

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


                 

</div>
<div class="panel panel-default table-responsive" style="text-align:center; overflow:auto;" >

    <table class="table table-bordered" >
    <tr>
        <th rowspan="3">Lokasi</th>
        <th style="text-align:center;" rowspan="3">All <br/>{{$allmember}}<div class="persen" style="visibility: hidden;">@if($allmember)100% @else 0% @endif</div></th>
        <th style="text-align:center;" rowspan="3">Aktif <br/>{{$activemember}}<div class="persen" style="visibility: hidden;">@if($activemember)100% @else 0% @endif</div></th>
        <th style="text-align:center;" colspan="8">Bergabung <br/>{{$joinmember}}<div class="persen" style="visibility: hidden;">@if($joinmember)100% @else 0% @endif</div></th>
        <th style="text-align:center;" rowspan="3">Expired <br/>{{$expired}}<div class="persen" style="visibility: hidden;">@if($expired)100% @else 0% @endif</div></th>
        <th style="text-align:center;" rowspan="3">Will&nbsp;Expired <br/>{{$will}}<div class="persen" style="visibility: hidden;">@if($will)100% @else 0% @endif</div></th>
    </tr>
    <tr>
        
        <td style="text-align:center;" colspan="4">Baru<br/><b>{{$memberbaru}}<div class="persen" style="visibility: hidden;">@if($per_memberbaru){{$per_memberbaru}}% @else 0% @endif</div></b></td>
        <td style="text-align:center;" colspan="4">Perpanjang <br/><b>{{$jumperpanjang}}<div class="persen" style="visibility: hidden;">@if($per_jumperpanjang){{$per_jumperpanjang}}% @else 0% @endif</div></b></td>
        <!---->
    </tr>
     <tr>
        <td>Paket&nbsp;1&nbsp;Bulan <br/><b>{{$paketsatu}}<div class="persen" style="visibility: hidden;">@if($per_paketsatu){{$per_paketsatu}}% @else 0% @endif</div></b></td>
        <td>Paket&nbsp;3&nbsp;Bulan<br/><b>{{$paketdua}}<div class="persen" style="visibility: hidden;">@if($per_paketdua){{$per_paketdua}}% @else 0% @endif</div></b></td>
        <td>Paket&nbsp;6&nbsp;Bulan<br/><b>{{$paketiga}}<div class="persen" style="visibility: hidden;">@if($per_paketiga){{$per_paketiga}}% @else 0% @endif</div></b></td>
        <td>Paket&nbsp;12&nbsp;Bulan<br/><b>{{$paketpat}}<div class="persen" style="visibility: hidden;">@if($per_paketpat){{$per_paketpat}}% @else 0% @endif</div></b></td>

        <td>Paket&nbsp;1&nbsp;Bulan <br/><b>
        {{$satu = App\Member::where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
         ->where('members.type','extends')
         ->join('package_prices','members.package_id','=','package_prices.id')
         ->where('package_prices.day','=','30')->get()->count()}}
         <div class="persen" style="visibility: hidden;">@if($satu ){{number_format(($satu/$jumperpanjang)*100,0,'.','')}} @else 0 @endif %</div>
         </b></td>
        <td>Paket&nbsp;3&nbsp;Bulan<br/><b>{{$dua = App\Member::where('members.expired_at','>',$currentdate)
          ->whereBetween('extended_at',[$backdate,$currentdate])
          ->where('members.type','extends')
          ->join('package_prices','members.package_id','=','package_prices.id')
          ->where('package_prices.day','=','90')->get()->count()}}
          <div class="persen" style="visibility: hidden;">@if($dua ){{number_format(($dua/$jumperpanjang)*100,0,'.','')}} @else 0 @endif %</div></b></td>
        <td>Paket&nbsp;6&nbsp;Bulan<br/><b>{{$tiga = App\Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
        ->where('members.type','extends')
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','180')->get()->count()}}<div class="persen" style="visibility: hidden;">@if($tiga ){{number_format(($tiga/$jumperpanjang)*100,0,'.','')}} @else 0 @endif %</div></b></td>
        <td>Paket&nbsp;12&nbsp;Bulan<br/><b>{{$empat =App\Member::where('members.expired_at','>',$currentdate)
        ->whereBetween('extended_at',[$backdate,$currentdate])
        ->where('members.type','extends')
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','365')->get()->count()}}<div class="persen" style="visibility: hidden;">@if($empat ){{number_format(($empat/$jumperpanjang)*100,0,'.','')}} @else 0 @endif %</div></b></td>
        <!--baru-->
    </tr>
    @foreach ($gyms as $gym)
    <tr>

        <td>{{$gym->title}}</td>
        <td>{{$satuu = $gym->members()->count()}} <div class="persen" style="visibility: hidden;">@if($satuu && $allmember){{number_format(($gym->members()->get()->count() / App\Member::get()->count())*100,0,'.','')}}%@else 0% @endif</div></td>
        <td>{{$active = $gym->members()->where('expired_at','>',$currentdate)->count()}}
        <div class="persen" style="visibility: hidden;">@if($active && $activemember){{number_format(($active / $activemember)*100,0,'.','')}}%@else 0% @endif</div></td>
        
        <td>{{$barusatu = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','30')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($barusatu && $paketsatu){{number_format(($barusatu / $paketsatu)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$barudua = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','90')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($paketdua && $barudua){{number_format(($barudua / $paketdua)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$barutiga = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','180')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($barutiga && $paketiga){{number_format(($barutiga / $paketiga)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$barupat = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','New')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','365')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($barupat && $paketpat){{number_format(($barupat / $paketpat)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$lamasatu = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','30')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($lamasatu && $satu){{number_format(($lamasatu / $satu)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$lamadua = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','90')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($lamadua && $dua){{number_format(($lamadua / $dua)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$lamatiga = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','180')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($lamatiga && $tiga){{number_format(($lamatiga / $tiga)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$lamapat = $gym->members()->where('members.expired_at','>',$currentdate)
         ->whereBetween('extended_at',[$backdate,$currentdate])
            ->where('members.type','extends')
            ->where('gym_id',$gym->id)
        ->join('package_prices','members.package_id','=','package_prices.id')
        ->where('package_prices.day','=','365')->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($lamapat && $empat){{number_format(($active / $activemember)*100,0,'.','')}}%@else 0% @endif</div>
        </td>
        <td>{{$ex = $gym->members()->where('expired_at','<',$currentdate)->get()->count()}}
        <div class="persen" style="visibility: hidden;">@if($ex && $expired){{number_format(($ex / $expired)*100,0,'.','')}}%@else 0% @endif</div></td>
         <td>{{$willx = $gym->members()->whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count()}} <div class="persen" style="visibility: hidden;">@if($willx && $will){{number_format(($willx / $will)*100,0,'.','')}}%@else 0% @endif</div></td>
    </tr>
    @endforeach
    </table>
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
      @foreach ($gyms as $gym)
   {
      value: {{number_format(($gym->members()->get()->count() / App\Member::get()->count())*100,0,'.','')}},
      label: '{{$gym->title}}',
      color: '#811BD6'
   },
    @endforeach
  
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
var context = document.getElementById('skills').getContext('2d');
var skillsChart = new Chart(context).Pie(pieData,options);
var barData ={
    labels: [@foreach($gyms as $gym)"{{$gym->title}}",@endforeach],
    datasets: 
    [
        {
            label: "Report",
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
                
            ],
            borderColor: [
                'rgba(255,99,132,1)'
               
            ],
            borderWidth: 1,
            data: [@foreach($gyms as $gym){{$gym->members()->count()}},@endforeach],
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
   <script type="text/javascript">
    var checkbox = $(".checkboxId");
    checkbox.change(function(event) {
        var checkbox = event.target;
        if (checkbox.checked) {
            var persen = document.getElementsByClassName('persen');
             var i;
            for (i = 0;i < persen.length; i++){
                 persen[i].style.visibility = "visible"; 
             } 
        } else {
           var persen = document.getElementsByClassName('persen');
             var i;
            for (i = 0;i < persen.length; i++){
                 persen[i].style.visibility = "hidden"; 
             }
        }
    });
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