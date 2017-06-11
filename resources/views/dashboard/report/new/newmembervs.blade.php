@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Member Baru (Perbandingan Periodik)')

@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form action="/u/report/newmembervs" class="form-inline" method="GET">
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
                        $new = DB::table('member_histories')
                                        ->where('gym_id',$gym_id)
                                        ->whereNotNull('new_register')
                                        ->whereBetween('expired', [$start_date, $end_date])
                                        ->count();
                        $new_1 = DB::table('member_histories')
                                        ->where('gym_id',$gym_id)
                                        ->whereNotNull('new_register')
                                        ->whereBetween('expired', [$start_date_1, $end_date_1])
                                        ->count();
                        $packet_1 = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $packet_1s = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $packet_2 = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $packet_2s = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $packet_3 = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $packet_3s = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $packet_4 = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $packet_4s = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $per_new = round((($new-$new_1)),1);
                        $per_packet_1 = round((($packet_1-$packet_1s)),1);
                        $per_packet_2 = round((($packet_2-$packet_2s)),1);
                        $per_packet_3 = round((($packet_3-$packet_3s)),1);
                        $per_packet_4 = round((($packet_4-$packet_4s)),1);

                        $jum_new = $new+$new_1;
                        $jum_packet_1 = $packet_1 + $packet_1s;
                        $jum_packet_2 = $packet_2 + $packet_2s;
                        $jum_packet_3 = $packet_3 + $packet_3s;
                        $jum_packet_4 = $packet_4 + $packet_4s;
                    }else if($nama_gym==2||$nama_gym==4){
                        $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                        $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                        $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                        $new = 0;
                        $new_1 = 0;
                        $packet_1 = 0;
                        $packet_1s = 0;
                        $packet_2 = 0;
                        $packet_2s = 0;
                        $packet_3 = 0;
                        $packet_3s = 0;
                        $packet_4 = 0;
                        $packet_4s = 0;
                        foreach($gym_ku as $id_gym){
                            $hit_new = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date, $end_date])
                                            ->count();
                            $hit_new_1 = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_1 = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_1s = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_2 = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_2s = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_3 = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_3s = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_4 = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_4s = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $new = $new + $hit_new;
                            $new_1 = $new_1 + $hit_new_1;
                            $packet_1 = $packet_1 + $hit_packet_1;
                            $packet_1s = $packet_1s + $hit_packet_1s;
                            $packet_2 = $packet_2 + $hit_packet_2;
                            $packet_2s = $packet_2s + $hit_packet_2s;
                            $packet_3 = $packet_3 + $hit_packet_3;
                            $packet_3s = $packet_3s + $hit_packet_3s;
                            $packet_4 = $packet_4 + $hit_packet_4;
                            $packet_4s = $packet_4s + $hit_packet_4s;
                        }
                        $per_new = round((($new-$new_1)),1);
                        $per_packet_1 = round((($packet_1-$packet_1s)),1);
                        $per_packet_2 = round((($packet_2-$packet_2s)),1);
                        $per_packet_3 = round((($packet_3-$packet_3s)),1);
                        $per_packet_4 = round((($packet_4-$packet_4s)),1);

                        $jum_new = $new+$new_1;
                        $jum_packet_1 = $packet_1 + $packet_1s;
                        $jum_packet_2 = $packet_2 + $packet_2s;
                        $jum_packet_3 = $packet_3 + $packet_3s;
                        $jum_packet_4 = $packet_4 + $packet_4s;
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
                  <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <h3 class="text-dark"><b>Baru</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jum_new}} <span class="text-muted">{{$per_new}}%</span></b></h3>
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
                                        <h3 class="text-dark"><b>{{$jum_packet_1}}</b></h3>
                                        <p class="text-muted">{{$per_packet_1}}%<br>Paket 1 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$jum_packet_2}}</b></h3>
                                        <p class="text-muted">{{$per_packet_2}}%<br>Paket 3 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$jum_packet_3}}</b></h3>
                                        <p class="text-muted">{{$per_packet_3}}%<br>Paket 6 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="md md-equalizer text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jum_packet_4}}</b></h3>
                                        <p class="text-muted">{{$per_packet_4}}%<br>Paket 12 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
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
                            @if($kode_gym==null)

                            @else
                            @foreach($kode_gym as $kode_gyms)
                            <?php 
                            $new = DB::table('member_histories')
                                            ->whereNotNull('new_register')
                                            ->where('gym_id',$gym_id)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $new_1 = DB::table('member_histories')
                                            ->whereNotNull('new_register')
                                            ->where('gym_id',$gym_id)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $packet_1 = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                            $packet_1s = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $packet_2 = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $packet_2s = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $packet_3 = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $packet_3s = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $packet_4 = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $packet_4s = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $jum_new = $new+$new_1;
                            $jum_packet_1 = $packet_1 + $packet_1s;
                            $jum_packet_2 = $packet_2 + $packet_2s;
                            $jum_packet_3 = $packet_3 + $packet_3s;
                            $jum_packet_4 = $packet_4 + $packet_4s;

                            $per_new = round((($new-$new_1)),1);
                            $per_packet_1 = round((($packet_1-$packet_1s)),1);
                            $per_packet_2 = round((($packet_2-$packet_2s)),1);
                            $per_packet_3 = round((($packet_3-$packet_3s)),1);
                            $per_packet_4 = round((($packet_4-$packet_4s)),1);
                            ?>
<script>
    var data = [
        {
            value: {{$per_new}},
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Baru"
        },
        {
            value: {{$per_packet_1}},
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Paket 1 Bulan"
        },
        {
            value: {{$per_packet_2}},
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Paket 3 Bulan"
        },
        {
            value: {{$per_packet_3}},
            color: "#949FB1",
            highlight: "#A8B3C5",
            label: "Paket 6 Bulan"
        },
        {
            value: {{$per_packet_4}},
            color: "#E3F203",
            highlight: "#E3F203",
            label: "Paket 12 Bulan"
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
                data : [{{$jum_new}}]
            },
            {
                fillColor : "#46BFBD",
                strokeColor : "#5AD3D1",
                data : [{{$jum_packet_1}}]
            },
            {
                fillColor : "#FDB45C",
                strokeColor : "#FDB45C",
                data : [{{$jum_packet_2}}]
            },
            {
                fillColor : "#D2691E",
                strokeColor : "#D2691E",
                data : [{{$jum_packet_3}}]
            },
            {
                fillColor : "#FF7F50",
                strokeColor : "#FF7F50",
                data : [{{$jum_packet_4}}]
            }
        ]
    }

    var context = document.getElementById('bar').getContext('2d');
    var skillsChart = new Chart(context).Bar(barData);
</script>
@endforeach
@endif
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
@endsection