@extends('dashboard._layout.dashboard')

@section('help-title', 'Membership')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Perpanjang Paket yang Sama')

@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form action="/u/report/longpacket" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Periode Awal</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}" required>
            <label>Periode Akhir</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range_1" value="{{old('range_1')}}{{Carbon\Carbon::parse($start_date_1)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date_1)->format('d-m-Y')}}" required>
            <label>Lokasi</label>
                <select name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
                    <option value="">Pilih Lokasi</option>
                    <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                    <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                    <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                    <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                </select>
            
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
                        <select name="zonas[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
                            @foreach($zonas as $zona)
                                <option @if(in_array($zona->id, $tertentuzona) == $tertentuzona)) selected @endif value="{{$zona->id}}">{{$zona->title}}</option>
                            @endforeach
                        </select>
                </div>
            </div>
            
            </div>
            <div class="" style="margin-top: 10px;">
                <div class="form-group">
                    <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
	
	@if($nama_gym==null)
		    
	@else
	    @foreach($title_gym as $title_gyms)    
			<?php 
			    if($nama_gym==1||$nama_gym==3){
			     	$gym_id = DB::table('gyms')->where('title',$title_gyms)->value('id');
                    $report_extends = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->whereBetween('extends', [$start_date, $end_date])
                                    ->count();
                    $long_ext_1 = DB::table('member_histories')
                    			->where('gym_id',$gym_id)
                                ->orderBy('extends', 'desc')
       							->whereBetween('extends', [$start_date, $end_date])
                                ->get();
                    $long_ext_2 = DB::table('member_histories')
                    			->where('gym_id',$gym_id)
                                ->orderBy('extends', 'desc')
                                ->whereBetween('extends', [$start_date_1, $end_date_1])
                                ->get();

                    $sama=0;
                    $upgrade=0;
                    $downgrade=0;
                    foreach ($long_ext_1 as $long_exts_1) {
                    	foreach ($long_ext_2 as $long_exts_2) {
    		                if($long_exts_1->package_price_id==$long_exts_2->package_price_id){
    		                	$sama++;
    		                }else{
    		                	if($long_exts_1->package_price_id>$long_exts_2->package_price_id){
    		                		$upgrade++;
    		                	}else{
    		                		$downgrade++;
    		                	}
    		                }
    		            }
                    }

                    $hitung_sama = ((5-$sama)/5*100);
                    $hitung_upgrade = ((1-$upgrade)/1*100);
                    $hitung_downgrade = ((2-$upgrade)/2*100);
                    $per_extends = ((8-$report_extends)/8*100);
                }else if($nama_gym==2||$nama_gym==4){
                    $report_extends = 0;
                    $sama=0;
                    $upgrade=0;
                    $downgrade=0;
                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    foreach($gym_ku as $gym_id){
                        $hit_report_extends = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                        $long_ext_1 = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->orderBy('extends', 'desc')
                                    ->whereBetween('extends', [$start_date, $end_date])
                                    ->get();
                        $long_ext_2 = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->orderBy('extends', 'desc')
                                    ->whereBetween('extends', [$start_date_1, $end_date_1])
                                    ->get();
                        $report_extends = $report_extends + $hit_report_extends;
                        foreach ($long_ext_1 as $long_exts_1) {
                            foreach ($long_ext_2 as $long_exts_2) {
                                if($long_exts_1->package_price_id==$long_exts_2->package_price_id){
                                    $sama++;
                                }else{
                                    if($long_exts_1->package_price_id>$long_exts_2->package_price_id){
                                        $upgrade++;
                                    }else{
                                        $downgrade++;
                                    }
                                }
                            }
                        }
                    }
                    $hitung_sama = ((5-$sama)/5*100);
                    $hitung_upgrade = ((1-$upgrade)/1*100);
                    $hitung_downgrade = ((2-$upgrade)/2*100);
                    $per_extends = ((8-$report_extends)/8*100); 
                }
       		?>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gym_id}}" aria-expanded="true" aria-controls="collapseOne">
                      @if($nama_gym==2||$nama_gym==4)
                                        {{$nama_zona}}
                                        @elseif($nama_gym==1||$nama_gym==3)
                                        {{$title_gyms}}
                                        @endif
                    </a>
                  </h4>
                </div>
                <div id="{{$gym_id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                    <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$report_extends}}</b></h3>
                                        <p class="text-muted">{{$per_extends}}%<br>Perpanjang</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$sama}}</b></h3>
                                        <p class="text-muted">{{$hitung_sama}}%<br>Paket yang sama</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$upgrade}}</b></h3>
                                        <p class="text-muted">{{$hitung_upgrade}}%<br>Upgrade</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$downgrade}}</b></h3>
                                        <p class="text-muted">{{$hitung_downgrade}}%<br>Downgrade</p>
                                    </div>
                                    <div class="clear   fix"></div>
                                </div>
                            </div>      
                  </div>
                </div>
              </div>
            </div>
		@endforeach	
	@endif
	
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
		@foreach($title_gym as $title_gyms)
			<?php 
                $report_extends = DB::table('member_histories')
                                ->whereBetween('extends', [$start_date, $end_date])
                                ->count();
                $long_ext_1 = DB::table('member_histories')
                            ->orderBy('extends', 'desc')
   							->whereBetween('extends', [$start_date, $end_date])
                            ->get();
                $long_ext_2 = DB::table('member_histories')
                            ->orderBy('extends', 'desc')
                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                            ->get();
                $sama=0;
                $upgrade=0;
                $downgrade=0;
                foreach ($long_ext_1 as $long_exts_1) {
                	foreach ($long_ext_2 as $long_exts_2) {
		                if($long_exts_1->package_price_id==$long_exts_2->package_price_id){
		                	$sama++;
		                }else{
		                	if($long_exts_1->package_price_id>$long_exts_2->package_price_id){
		                		$upgrade++;
		                	}else{
		                		$downgrade++;
		                	}
		                }
		            }
                }
                if($nama_gym==null){
                    $hitung_sama = 0;
                    $hitung_upgrade = 0;
                    $hitung_downgrade = 0;
                    $per_extends = 0;
                }else{
                    $hitung_sama = ((5-$sama)/5*100);
                    $hitung_upgrade = ((1-$upgrade)/1*100);
                    $hitung_downgrade = ((2-$upgrade)/2*100);
                    $per_extends = ((8-$report_extends)/8*100);
                }
            ?>
<script>
    var data = [
        {
            value: {{$per_extends}},
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Perpanjang"
        },
        {
            value: {{$hitung_sama}},
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Paket yang sama"
        },
        {
            value: {{$hitung_upgrade}},
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Upgrade"
        },
        {
            value: {{$hitung_downgrade}},
            color: "#949FB1",
            highlight: "#A8B3C5",
            label: "Downgrade"
        }
    ];
    var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).Pie(data,options);

    var barData = {
    	labels : ["Semua"],
    	datasets : [
    		{
    			fillColor : "#F7464A",
    			strokeColor : "#F7464A",
    			data : [{{$report_extends}}]
    		},
    		{
    			fillColor : "#46BFBD",
    			strokeColor : "#5AD3D1",
    			data : [{{$sama}}]
    		},
            {
                fillColor : "#FDB45C",
                strokeColor : "#FDB45C",
                data : [{{$upgrade}}]
            },
            {
                fillColor : "#949FB1",
                strokeColor : "#949FB1",
                data : [{{$downgrade}}]
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
       }else if(select.value==4){ 
            document.getElementById("hidden_zona").style.display = "block"; 
            document.getElementById("hidden_gym").style.display = "none"; 
       }else{
            document.getElementById("hidden_zona").style.display = "none"; 
            document.getElementById("hidden_gym").style.display = "none"; 
       }
    } 
</script>
@endforeach
@endsection