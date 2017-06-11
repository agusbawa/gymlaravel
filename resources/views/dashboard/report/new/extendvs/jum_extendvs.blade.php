@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Perbandingan Perpanjangan Member')

@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form action="/u/report/extendvs" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Periode Awal</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range" value="" required>
            <label>Periode Akhir</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range_1" value="" required>
            <label>Lokasi</label>
                <select name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
                    <option value="">Pilih Lokasi</option>
                    <option value="0">Semua</option>
                    <option value="1">Semua Gym</option>
                    <option value="2">Semua Zona</option>
                    <option value="3">Gym Tertentu</option>
                    <option value="4">Zona Tertentu</option>
                    <option value="5">Gym Dalam Zona Tertentu</option>
                </select>

            <div class="form-group checkbox">
                <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                <label for="checkbox0">
                    Tampilkan %
                </label>
            </div>
                       
            <div id="hidden_gym" style="display: none;">
                <div style="margin-top: 10px;">
                    <label for="">Nama Gym</label>
                        <select name="gyms[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Gym">
                            @foreach($gyms as $gym)
                                <option @if(in_array($gym->id, $tertentugym) == $tertentugym)) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        </select>
                </div>
            </div>

            <div id="hidden_zona" style="display: none;">
                <div style="margin-top: 10px;">
                    <label for="">Nama Zona</label>
                        <select name="zonasku[]" id="zona" multiple="" class="select2" placeholder="Silakan Pilih Nama Zona">
                            @foreach($zonas as $zona)
                                <option @if(in_array($zona->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zona->id}}">{{$zona->title}}</option>
                            @endforeach
                        </select>
                </div>
            </div>

            <div id="hidden_zona1" style="display: none;">
                <div style="margin-top: 10px;">
                    <label for="">Nama Zona</label>
                        <select name="zonas[]" id="zonaku" class="select2 form-control" placeholder="Silakan Pilih Nama Zona">
                            <option value="0" selected>Pilih Zona</option>
                            @foreach($zonas as $zona)
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
            
            </div>
            <div class="" style="margin-top: 10px;">
                <div class="form-group">
                    <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                </div>
                <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelextendvs"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFextendvs"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    
           <?php $jum_exp = 0;
                    $jum_ext = 0;
                    $jum_no = 0;
            ?>
                @foreach($title_gym as $title_gyms)
                <?php 
                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $hit_expired = 0;
                    $hit_expired_1 = 0;
                    $hit_extends = 0;
                    $hit_extends_1 = 0;
                    $hit_no = 0;
                    $hit_no_1 = 0;
                    foreach($gym_ku as $gym_id){
                            $report_expired = DB::table('member_histories')
                                            ->count();
                            $report_expired_1 = DB::table('member_histories')
                                            ->count();
                            $report_extends = DB::table('member_histories')
                                            ->count();
                            $report_extends_1 = DB::table('member_histories')
                                            ->count();

                            $long_exps = DB::table('member_histories')
                                        ->first();
                            $no=0;
                            if($long_exps==null){
                                $range_date = "0"; 
                            }else{
                                $long_date = $long_exps->expired;
                                $now  = Carbon\Carbon::parse(Carbon\Carbon::now());
                                $end  = Carbon\Carbon::parse($long_date);
                                $range_date = $end->diffInDays($now); 
                            }
                            if ($range_date>1){
                                $no++;
                            }

                            $long_exps_1 = DB::table('member_histories')
                                            ->first();
                            $no_1=0;
                            if($long_exps_1==null){
                                $range_date_1="0";
                            }else{
                                $long_date_1 = $long_exps_1->expired;
                                $now_1  = Carbon\Carbon::parse(Carbon\Carbon::now());
                                $end_1  = Carbon\Carbon::parse($long_date_1);
                                $range_date_1 = $end_1->diffInDays($now_1);
                            }
                                if ($range_date_1>1){
                                    $no_1++;
                            }
                            $hit_expired = $hit_expired+$report_expired;
                            $hit_expired_1 = $hit_expired_1+$report_expired_1;
                            $hit_extends = $hit_extends+$report_extends;
                            $hit_extends_1 = $hit_extends_1+$report_extends_1;
                            $hit_no = $hit_no + $no;
                            $hit_no_1 = $hit_no_1 + $no_1;
                    }
                    $per_expired = round((($hit_expired+$hit_expired_1)*100),2);
                    $per_extends = round((($hit_extends+$hit_extends_1)*100),2);
                    $per_no = (($hit_no+$hit_no_1))*100;

                    $jum_exp = $jum_exp + $hit_expired+$hit_expired_1;
                    $jum_ext = $jum_ext + $hit_extends+$hit_extends_1;
                    $jum_no = $jum_no + $hit_no+$hit_no_1;      
                ?>
                @endforeach 
                
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#1" aria-expanded="true" aria-controls="collapseOne">
                          Semua
                        </a>
                      </h4>
                    </div>
                    <div id="1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">

                             <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jum_exp}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen1" style="visibility: hidden;">{{$per_expired}}%</span><br>Expired</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jum_ext}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen2" style="visibility: hidden;">{{$per_extends}}%</span><br>Perpanjangan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jum_no}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">{{$per_no}}%</span><br>Tidak Perpanjang</p>
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
            document.getElementById("hidden_persen1").style.visibility = "visible"; 
            document.getElementById("hidden_persen2").style.visibility = "visible"; 
            document.getElementById("hidden_persen3").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3").style.visibility = "hidden";  
        }
    });
</script>
                
</div>
<div class="col-lg-6">
    <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Pie Chart</b></h4>

            <canvas id="myChart" width="300" height="300"></canvas>
    </div>
</div>
<div class="col-lg-6">
    <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Bar Chart</b></h4>
               
            <canvas id="bar" width="300" height="300"></canvas>
    </div>
</div>
<?php $per_no = 0; ?>
            @foreach($title_gym as $title_gyms)
                <?php 
              
                    $gym_id = DB::table('gyms')->where('zona_id',$title_gyms)->value('id');

                    $report_expired = DB::table('member_histories')
                                    ->count();
                    $report_expired_1 = DB::table('member_histories')
                                    ->count();
                    $report_extends = DB::table('member_histories')
                                    ->count();
                    $report_extends_1 = DB::table('member_histories')
                                    ->count();
                    
                        $per_expired = round((($report_expired+$report_expired_1)*100),2);
                        $per_extends = round((($report_extends+$report_extends_1)*100),2);
                        $per_no = 0;
                    
                        $jum_exp = ($report_expired+$report_expired_1);
                        $jum_ext = ($report_extends+$report_extends_1);
                        $jum_no = 0;
                   
                ?>
<script>
    var data = [
        {
            value: {{$per_expired}},
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Expired"
        },
        {
            value: {{$per_extends}},
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Perpanjang"
        },
        {
            value: {{$per_no}},
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Tidak Perpanjang"
        }
    ];
    var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).Pie(data,options);

    var barData = {
        labels : [""],
        datasets : [
            {
                fillColor : "#F7464A",
                strokeColor : "#F7464A",
                data : [{{$jum_exp}}]
            },
            {
                fillColor : "#46BFBD",
                strokeColor : "#5AD3D1",
                data : [{{$jum_ext}}]
            },
            {
                fillColor : "#FDB45C",
                strokeColor : "#FDB45C",
                data : [{{$jum_no}}]
            }
        ]
    }
    var context = document.getElementById('bar').getContext('2d');
    var skillsChart = new Chart(context).Bar(barData);
</script>
        @endforeach
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