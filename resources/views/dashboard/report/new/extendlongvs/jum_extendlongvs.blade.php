@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Perbandingan Member Perpanjangan')

@section('content')
<div class="row">
    <div class="col-md-12" style="margin-bottom: 10px;">
        <form action="/u/report/extendlongvs" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Periode Awal</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}" required>
            <label>Periode Akhir</label>
                <input type="text" class="form-control input-daterange-datepicker" name="range_1" value="{{old('range_1')}}{{Carbon\Carbon::parse($start_date_1)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date_1)->format('d-m-Y')}}" required>
                <select id="valuepayment" name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
    	            <option value="" selected="">Pilih Lokasi</option>
                    <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                    <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                    <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                    <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                    <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                    <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>
                </select>
                <select id="valuepayment" name="pilih_kat" class="select2 form-control" required>
                    <option value="" selected="">Pilih Kategori</option>
                    <option @if($pilih_kat=="Expired") selected @endif value="Expired">Expired</option>
                    <option @if($pilih_kat=="Perpanjang") selected @endif value="Perpanjang">Perpanjang</option>
                    <option @if($pilih_kat=="Tidak Perpanjang") selected @endif value="Tidak Perpanjang">Tidak Perpanjang</option>
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
                        <select name="zonas[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
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
                <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelextendlongvs"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFextendlongvs"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
    
        <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="text-right">
                                        <h3 class="text-dark" style="text-align: center;"><b>{{$pilih_kat}}</b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


            <?php
                if($pilih_kat=='Expired'){
                            $nilai_data=11;
                        }
                        elseif($pilih_kat=='Perpanjang'){
                            $nilai_data=8;
                        }elseif($pilih_kat=='Tidak Perpanjang'){
                            $nilai_data=3;
                        }
            ?>
                @foreach($title_gym as $title_gyms)
               
                <?php 
                 if($pilih_kat=='Expired'){
                            $pil_kat='expired';
                        }
                        elseif($pilih_kat=='Perpanjang'){
                            $pil_kat='extends';
                        }elseif($pilih_kat=='Tidak Perpanjang'){
                            $pil_kat='expired';
                        }

                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    $jumlah = 0;
                    $jumlahs = 0;
                    $packet_1 = 0;
                    $packet_1s = 0;
                    $packet_2 = 0;
                    $packet_2s = 0; 
                    $packet_3 = 0;
                    $packet_3s = 0; 
                    $packet_4 = 0;
                    $packet_4s = 0;
                    foreach($gym_ku as $id_gym){
                        if($pilih_kat=='Expired'){
                            $pil_kat='expired';
                        }
                        elseif($pilih_kat=='Perpanjang'){
                            $pil_kat='extends';
                        }
                        $hit_jumlah = DB::table('member_histories')
                                        ->count();
                        $hit_jumlahs = DB::table('member_histories')
                                        ->count();
                        $hit_packet_1 = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->count();
                        $hit_packet_1s = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->count();
                        $hit_packet_2 = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->count();
                        $hit_packet_2s = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->count();    
                        $hit_packet_3 = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->count();
                        $hit_packet_3s = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->count();    
                        $hit_packet_4 = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->count();
                        $hit_packet_4s = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->count();  
                        $jumlah = $jumlah + $hit_jumlah;
                        $jumlahs = $jumlahs + $hit_jumlahs;
                        $packet_1 = $packet_1 + $hit_packet_1;
                        $packet_1s = $packet_1s + $hit_packet_1s;
                        $packet_2 = $packet_2 + $hit_packet_2;
                        $packet_2s = $packet_2s + $hit_packet_2s; 
                        $packet_3 = $packet_3 + $hit_packet_3;
                        $packet_3s = $packet_3s + $hit_packet_3s; 
                        $packet_4 = $packet_4 + $hit_packet_4;
                        $packet_4s = $packet_4s + $hit_packet_4s;
                    }
                    $total_jum = ($jumlah+$jumlahs);
                    $tot_packet1 = ($packet_1+$packet_1s);
                    $tot_packet2 = ($packet_2+$packet_2s);
                    $tot_packet3 = ($packet_3+$packet_3s);
                    $tot_packet4 = ($packet_4+$packet_4s);

                    $per_jum = round((($total_jum/$nilai_data)*100),2);
                    $per_pac1 = round((($tot_packet1/$nilai_data)*100),2);
                    $per_pac2 = round((($tot_packet2/$nilai_data)*100),2);
                    $per_pac3 = round((($tot_packet3/$nilai_data)*100),2);
                    $per_pac4 = round((($tot_packet4/$nilai_data)*100),2);        
 ?>     
 @endforeach 
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gym_id}}" aria-expanded="true" aria-controls="{{$gym_id}}">
                          Semua
                        </a>
                      </h4>
                    </div>
                    <div id="{{$gym_id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                   
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="pull-left">
                                        <h3 class="text-dark"><b>Jumlah</b></h3>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$total_jum}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen1" style="visibility: hidden;">{{$per_jum}}%</span></p>
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
                                        <h3 class="text-dark"><b>{{$tot_packet1}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen2" style="visibility: hidden;">{{$per_pac1}}%</span><br>Paket 1 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$tot_packet2}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">{{$per_pac2}}%</span><br>Paket 3 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$tot_packet3}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen4" style="visibility: hidden;">{{$per_pac3}}%</span><br>Paket 6 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$tot_packet4}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen5" style="visibility: hidden;">{{$per_pac4}}%</span><br>Paket 12 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div> 
                  
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
            document.getElementById("hidden_persen4").style.visibility = "visible";
            document.getElementById("hidden_persen5").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3").style.visibility = "hidden"; 
            document.getElementById("hidden_persen4").style.visibility = "hidden"; 
            document.getElementById("hidden_persen5").style.visibility = "hidden";  
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
    <?php
        $per_jum = 0;
        $per_pac1 = 0;
        $per_pac2 = 0;
        $per_pac3 = 0;
        $per_pac4 = 0;
    ?>
                            @foreach($title_gym as $title_gyms)
                            <?php 
             
                if($pilih_kat=='Expired'){
                            $pil_kat='expired';
                        }
                        elseif($pilih_kat=='Perpanjang'){
                            $pil_kat='extends';
                        }else{
                            $pil_kat='expired';
                        }

                $jumlah = DB::table('member_histories')
                                ->count();
                $jumlahs = DB::table('member_histories')
                                ->count();
                $packet_1 = DB::table('member_histories')
                                ->where('package_price_id','1')
                                ->count();
                $packet_1s = DB::table('member_histories')
                                ->where('package_price_id','1')
                                ->count();    
                $packet_2 = DB::table('member_histories')
                                ->where('package_price_id','2')
                                ->count();
                $packet_2s = DB::table('member_histories')
                                ->where('package_price_id','2')
                                ->count();    
                $packet_3 = DB::table('member_histories')
                                ->where('package_price_id','3')
                                ->count();
                $packet_3s = DB::table('member_histories')
                                ->where('package_price_id','3')
                                ->count();    
                $packet_4 = DB::table('member_histories')
                                ->where('package_price_id','4')
                                ->count();
                $packet_4s = DB::table('member_histories')
                                ->where('package_price_id','4')
                                ->count();

                if($pilih_kat=='Expired'){
                    $nilai_data=11;
                }elseif($pilih_kat=='Perpanjang'){
                    $nilai_data=8;
                }elseif($pilih_kat=='Tidak Perpanjang'){
                    $nilai_data=3;
                }

                if($start_date==null){
                    $total_jum = 0;
                    $tot_packet1 = 0;
                    $tot_packet2 = 0;
                    $tot_packet3 = 0;
                    $tot_packet4 = 0;
                }else{                
                    $total_jum = ($jumlah+$jumlahs);
                    $tot_packet1 = ($packet_1+$packet_1s);
                    $tot_packet2 = ($packet_2+$packet_2s);
                    $tot_packet3 = ($packet_3+$packet_3s);
                    $tot_packet4 = ($packet_4+$packet_4s);

                    $per_jum = round((($total_jum/$nilai_data)*100),2);
                    $per_pac1 = round((($tot_packet1/$nilai_data)*100),2);
                    $per_pac2 = round((($tot_packet2/$nilai_data)*100),2);
                    $per_pac3 = round((($tot_packet3/$nilai_data)*100),2);
                    $per_pac4 = round((($tot_packet4/$nilai_data)*100),2);
            }
                ?>
<script>
    var data = [
        {
            value: {{$per_jum}},
            color:"#F7464A",
            highlight: "#FF5A5E",
            label: "Jumlah"
        },
        {
            value: {{$per_pac1}},
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Paket 1 Bulan"
        },
        {
            value: {{$per_pac2}},
            color: "#FDB45C",
            highlight: "#FFC870",
            label: "Paket 3 Bulan"
        },
        {
            value: {{$per_pac3}},
            color: "#949FB1",
            highlight: "#A8B3C5",
            label: "Paket 6 Bulan"
        },
        {
            value: {{$per_pac4}},
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
                    data : [{{$total_jum}}]
                },
                {
                    fillColor : "#46BFBD",
                    strokeColor : "#5AD3D1",
                    data : [{{$tot_packet1}}]
                },
                {
                    fillColor : "#FDB45C",
                    strokeColor : "#FDB45C",
                    data : [{{$tot_packet2}}]
                },
                {
                    fillColor : "#D2691E",
                    strokeColor : "#D2691E",
                    data : [{{$tot_packet3}}]
                },
                {
                    fillColor : "#FF7F50",
                    strokeColor : "#FF7F50",
                    data : [{{$tot_packet4}}]
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