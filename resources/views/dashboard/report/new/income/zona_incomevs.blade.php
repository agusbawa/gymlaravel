@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Perbandingan Pendapatan')

@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form action="/u/report/income" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Periode Awal</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}" required>
            <label>Lokasi</label>
                <select name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
                    <option value="">Pilih Lokasi</option>
                    <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                    <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                    <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                    <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                    <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                    <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>
                </select>
                <select id="valuepayment" name="pilih_kat" class="select2 form-control" required>
                    <option value="" selected="">Pilih Kategori</option>
                    <option value="Baru">Baru</option>
                    <option value="Perpanjang">Perpanjang</option>
                </select>
            </div>

            <div class="form-group checkbox">
                <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                <label for="checkbox0">
                    Tampilkan %
                </label>
            </div>

            <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelincome"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
            <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFincome"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            
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
                        <select name="zonasku[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
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
            
            <div class="" style="margin-top: 10px;">
                <div class="form-group">
                    <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
	
          
            <?php
                if($pilih_kat=='Baru'){
                            $nilai_data=11;
                        }
                        elseif($pilih_kat=='Perpanjang'){
                            $nilai_data=8;
                        }
            ?>
                @foreach($title_gym as $title_gyms)
                
                <?php 
                $tot_trans = 0;
                $tot_pack1 = 0;
                $tot_pack2 = 0;
                $tot_pack3 = 0;
                $tot_pack4 = 0;
                $gab_jum = 0; 
                $gab_trans = 0;
                $gab_total = 0;
                $gab_member = 0;
                $gab_package = 0;
                $gab_trainer = 0;
                $gab_per = 0;
                $gab_kantin = 0;
                $gab_tot = 0;  
              
                    $gym_ku = DB::table('gyms')->where('title',$title_gyms)->value('id');
                    if($pilih_kat=='Baru'){
                        $gym_id = DB::table('member_histories')->where('gym_id',$gym_ku)->whereNotNull('new_register')->value('gym_id');
                    }else{
                        $gym_id = DB::table('member_histories')->where('gym_id',$gym_ku)->whereNotNull('extends')->value('gym_id');
                    }
                    $total_trans = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');
                    $jum_trans = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->count();

                    $total_pack1 = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('package_price_id','1')
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');

                    $total_pack2 = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('package_price_id','2')
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');

                    $total_pack3 = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('package_price_id','3')
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');

                    $total_pack4 = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('package_price_id','4')
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');

                    $tot_trans = $total_pack1 + $total_pack2 + $total_pack3 + $total_pack4;
                    $tot_pack1 = $tot_pack1 + $total_pack1;
                    $tot_pack2 = $tot_pack2 + $total_pack2;
                    $tot_pack3 = $tot_pack3 + $total_pack3;
                    $tot_pack4 = $tot_pack4 + $total_pack4;

                    $members_harian = DB::table('members_harian')
                                    ->where('gym_id',$gym_ku)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->pluck('package_id');
                    $members_count = DB::table('members_harian')
                                    ->where('gym_id',$gym_ku)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->count();
                    
                    $jum_package=0;
                    foreach ($members_harian as $members_harians) {
                        $package = DB::table('package_prices')->where('package_id',$members_harians)
                                    ->value('price');
                        $jum_package=$jum_package+$package;
                    }

                    $per_trainer = DB::table('personal_trainer')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$gym_ku)
                                    ->value('fee_trainer');
                    $per_gym = DB::table('personal_trainer')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$gym_ku)
                                    ->value('fee_gym');
                    $per_jumlah = $per_trainer+$per_gym;


                    $count_trainer = DB::table('personal_trainer')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$gym_ku)
                                    ->count();

                    $count_kantin = DB::table('kantin')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$gym_ku)
                                    ->count();

                    $tot_kantin=0;
                    $jum_kantin = DB::table('kantin')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$gym_ku)
                                    ->value('total');
                    $tot_kantin = $tot_kantin + $jum_kantin;
    

                    $jumlah = $tot_trans+$jum_package+$per_jumlah+$tot_kantin;
                    
                $gab_jum = $jumlah;
                $gab_trans = $jum_trans;
                $gab_total = $tot_trans;
                $gab_member = $members_count;
                $gab_package = $jum_package;
                $gab_trainer = $count_trainer;
                $gab_per = $per_jumlah;
                $gab_kantin = $count_kantin;
                $gab_tot = $tot_kantin;    
 ?>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gym_ku}}" aria-expanded="true" aria-controls="collapseOne">
                      <tr>
                
                    {{$title_gyms}}

                    </a>
                  </h4>
                </div>
                <div id="{{$gym_ku}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body"> 
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <h3 class="text-dark"><b>Pendapatan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$gab_jum}}</b></h3>
                                        <p class="text-muted"></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-equalizer text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$gab_trans}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen1{{$gym_ku}}" style="visibility: hidden;">{{$gab_total}}%</span><br>{{$pilih_kat}}</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-pink pull-left">
                                        <i class="md md-equalizer text-pink"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$gab_member}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen2{{$gym_ku}}" style="visibility: hidden;">{{$gab_package}}%</span><br>Harian</p>
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
                                        <h3 class="text-dark"><b>{{$gab_trainer}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3{{$gym_ku}}" style="visibility: hidden;">{{$gab_per}}%</span><br>Personal Trainer</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="md md-equalizer text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$gab_kantin}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen4{{$gym_ku}}" style="visibility: hidden;">{{$gab_tot}}%</span><br>Kantin</p>
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
            document.getElementById("hidden_persen1{{$gym_ku}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen2{{$gym_ku}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen3{{$gym_ku}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen4{{$gym_ku}}").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1{{$gym_ku}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2{{$gym_ku}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3{{$gym_ku}}").style.visibility = "hidden";  
            document.getElementById("hidden_persen4{{$gym_ku}}").style.visibility = "hidden";  
        }
    });
</script>
                @endforeach 
		
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
                            <?php $id_title = DB::table('gyms')->pluck('id'); ?>
                    @foreach($id_title as $id_titles)
                            <?php 
                    $total_trans = DB::table('transactions')
                                ->where('gym_id',$id_titles)
                                ->whereBetween('created_at', [$start_date, $end_date])
                                ->value('total');

                    $members_harian = DB::table('members_harian')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->pluck('package_id');
                    
                    $jum_package=0;
                    foreach ($members_harian as $members_harians) {
                        $package = DB::table('package_prices')->where('package_id',$members_harians)
                                    ->value('price');
                        $jum_package=$jum_package+$package;
                    }

                    $per_trainer = DB::table('personal_trainer')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->value('fee_trainer');
                    $per_gym = DB::table('personal_trainer')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->value('fee_gym');

                    $per_jumlah = $per_trainer+$per_gym;

                    $jum_kantin = DB::table('kantin')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->value('total');

                    $gab_total = $total_trans;
                    $gab_package = $jum_package;
                    $gab_per = $per_jumlah;
                    $gab_tot = $jum_kantin;    

                ?>
<script>
    var data = [
        {
            value: {{$gab_total}},
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Baru"
        },
        {
            value: {{$gab_package}},
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Harian"
        },
        {
            value: {{$gab_per}},
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Personal Trainer"
        },
        {
            value: {{$gab_tot}},
            color: "#949FB1",
            highlight: "#949FB1",
            label: "Kantin"
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
            data : [{{$gab_total}}]
        },
        {
            fillColor : "#46BFBD",
            strokeColor : "#5AD3D1",
            data : [{{$gab_package}}]
        },
        {
            fillColor : "#FDB45C",
            strokeColor : "#FDB45C",
            data : [{{$gab_per}}]
        },
        {
            fillColor : "#949FB1",
            strokeColor : "#949FB1",
            data : [{{$gab_tot}}]
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