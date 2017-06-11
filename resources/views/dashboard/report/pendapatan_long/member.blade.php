@extends('dashboard._layout.dashboard')

@section('help-title', 'Report Pendapatan')
@section('title', 'Report Pendapatan')
@section('page-title', 'Report Pendapatan Member Perpanjangan')
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
                                <select name="zonas[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
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
        <tr>
            <td colspan="15">Semua</td>
        </tr>
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


<script>
 var pieData = [
   {
      value: @if($dua && $total){{number_format(($dua/$total)*100,0,'.','')}}@else 0 @endif,
      label: 'Paket 3 Bulan',
      color: '#811BD6'
   },
   {
      value: @if($satu && $total){{number_format(($satu/$total)*100,0,'.','')}}@else 0 @endif,
      label: 'Paket 1 Bulan',
      color: '#8C9BD6'
   },
   {
      value: @if($empat && $total){{number_format(($empat/$total)*100,0,'.','')}}@else 0 @endif,
      label: 'Paket 6 Bulan',
      color: '#8C9BD6'
   },
     {
      value: @if($tiga && $total){{number_format(($tiga/$total)*100,0,'.','')}}@else 0 @endif,
      label: 'Paket 12 Bulan',
      color: '#8C9BD6'
   },
  
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
    var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData,options);

         var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData);
var barData ={
    labels: ["Paket 1 Bulan","Paket 3 Bulan","Paket 6 Bulan","Paket 12 Bulan"],
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
            data: [{{$satu}},{{$dua}},{{$tiga}},{{$empat}}],
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