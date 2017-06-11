    @extends('dashboard._layout.dashboard')

@section('help-title', 'Filter')
@section('title', 'Filter')
@section('page-title', 'Filter')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('filter')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left" style="margin-bottom: 10px;">
               <form action="/u/report/memberbarusearch" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option value="">Pilih Lokasi</option>
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
                        <input type="text" class="form-control input-daterange-datepicker" name="periode" value="{{old('periode')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>
                    <div class="form-group checkbox">
                        <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                        <label for="checkbox0">
                            Tampilkan %
                        </label>
                    </div>

                    @if($nama_gym==5)
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMemberBaru/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMemberBaru/search?lokasi={{$nama_gym}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                    @else
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMemberBaru/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugym as $tent)&zonasku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMemberBaru/search?lokasi={{$nama_gym}}@foreach($tertentugym as $tent)&zonasku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
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
        <?php
        $date_awal = Carbon\Carbon::parse($backdate)->format('d-m-Y');
        $date_akhir = Carbon\Carbon::parse($currentdate)->format('d-m-Y');
        ?>

    <div class="panel panel-default table-responsive" style="text-align:center; overflow:auto;" >

    <table class="table table-bordered" >
        <tr>
            <th rowspan="2" class="text-center">Lokasi</th>
            <th colspan="5" class="text-center">Member Baru <br/>{{$all = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($all && $all)
                                            {{number_format(($all/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
        <tr>
        <td>Jumlah <br/>{{$all = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($all && $all)
                                            {{number_format(($all/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif </td>
        <td>Paket&nbsp;1&nbsp;Bulan <br/><b>{{$paketsatu = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','30')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;">@if($all && $paketsatu)
                                            {{number_format(($paketsatu/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif  </div></b></td>
        <td>Paket&nbsp;3&nbsp;Bulan<br/><b>{{$paketdua = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','90')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;">
                                        @if($all && $paketdua)
                                            {{number_format(($paketdua/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif  
                                        </div></b></td>
        <td>Paket&nbsp;6&nbsp;Bulan<br/><b>{{$paketiga = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','180')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;">@if($all && $paketiga)
                                            {{number_format(($paketiga/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif   </div></b></td>
        <td>Paket&nbsp;12&nbsp;Bulan<br/><b>{{$paketpat = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','365')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;">@if($all && $paketpat)
                                            {{number_format(($paketpat/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif   </div></b></td>

        </tr>
        @foreach($zonas as $zona)
            <tr>
                <td>{{$zona->title}}</td>
                <td>{{$allzona = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allzona && $all)
                                            {{number_format(($allzona/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif
                </td>
                <td>{{$zonasatu = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','30')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($paketsatu && $zonasatu)
                                            {{number_format(($zonasatu/$paketsatu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif
                </td>
                <td>{{$zonadua = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','90')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($paketdua && $zonadua)
                                            {{number_format(($zonadua/$paketdua)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif
                </td>
                <td>{{$zonatiga = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','180')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($zonatiga && $paketiga)
                                            {{number_format(($zonatiga/$paketiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif
                </td>
                 <td>{{$zonaempat = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','=','365')
                                         ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('new_register',[$backdate,$currentdate])
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($zonaempat && $paketpat)
                                            {{number_format(($zonaempat/$paketpat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif
                </td>
            </tr>
        @endforeach
        </table>
        </div>
        
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
     @foreach ($zonas as $zona)
   {
       
      value: @if(
          $allzona = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('members.type','=','New')
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count() && $all
      ) {{number_format(($allzona = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('members.type','=','New')
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()/$all)*100,0,'.','')}}
                                         @else
                                         0
                                         @endif,
      label: '{{$zona->title}}',
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
    labels: [@foreach($zonas as $zona)"{{$zona->title}}",@endforeach],
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
            data: [@foreach($zonas as $zona) {{$allzona = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('members.type','=','New')
                                        ->join('gyms','gyms.id','=','members.gym_id')
                                        ->join('zonas','zonas.id','=','gyms.zona_id')
                                        ->where('zonas.id',$zona->id)
                                        ->get()->count()}}, @endforeach],
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