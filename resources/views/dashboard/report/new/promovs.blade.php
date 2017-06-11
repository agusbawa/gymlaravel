@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Perbandingan Promo')

@section('content')
<div class="row">
    <div class="col-md-10" style="margin-bottom: 10px;">
        <form action="/u/report/promovs" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Lokasi</label>
                <select name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
                    <option value="">Pilih Lokasi</option>
                    <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                    <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                    <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                    <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                </select>
            
            <label>Promo</label>
                <select onchange="nilaiTransaksi()" id="valuepayment" name="title_promo" class="select2 form-control">
                    <option value="" selected="">Bandingkan beberapa Promo</option>
                @foreach($promoku as $promokus)    
                    <?php
                         $title_promo = DB::table('promos')->where('id',$promokus)->value('title');
                    ?>
                    <option value="{{$title_promo}}">{{$title_promo}}</option>
                @endforeach
                </select>
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
            <div class="" style="margin-top: 10px;">
                <div class="form-group">
                	<button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="panel panel-default">
	
        <?php $no=1; ?>	
        @if($nama_gym==null)
           
        @else
            @foreach($title_gym as $title_gyms)
            
            @foreach($promo as $promos)
            <?php
            $tot_trans = 0;
            $tot_non = 0;
            $tot_new = 0;
            $tot_ext = 0;
            if($nama_gym==1||$nama_gym==3){
                $id_gym = DB::table('gyms')->where('title',$title_gyms)->value('id');
                $title_promo = DB::table('promos')->where('id',$promos)->value('title');
                $id_promo = DB::table('member_histories')->where('gym_id',$id_gym)->value('promo_id');
 
                $trans = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id',$promos)
                        ->count();
                $non_promo = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id','0')
                        ->count();
                $jum_trans = $trans + $non_promo;
                $trans_new = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id',$promos)
                        ->where('status','Active')
                        ->count();
                $trans_ext = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id',$promos)
                        ->where('status','Pending')
                        ->count();

                $id_nonpromo = DB::table('transactions')
                            ->where('gym_id',$id_gym)
                            ->where('promo_id','0')
                            ->value('package_price_id');
                $id_trans = DB::table('transactions')
                            ->where('gym_id',$id_gym)
                            ->where('promo_id',$promos)
                            ->value('package_price_id');
                $id_new = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id',$promos)
                        ->where('status','Active')
                        ->value('package_price_id');
                $id_ext = DB::table('transactions')
                        ->where('gym_id',$id_gym)
                        ->where('promo_id',$promos)
                        ->where('status','Pending')
                        ->value('package_price_id');

                $total_nonpromo = DB::table('package_prices')
                            ->where('package_id',$id_nonpromo)
                            ->value('price');
                $total_trans = DB::table('package_prices')
                            ->where('package_id',$id_trans)
                            ->value('price');
                $total_new = DB::table('package_prices')
                            ->where('package_id',$id_new)
                            ->value('price');
                $total_ext = DB::table('package_prices')
                            ->where('package_id',$id_ext)
                            ->value('price');

                $tot_non = $tot_trans + $total_nonpromo;
                $tot_trans = $tot_trans + $total_trans;
                $tot_new = $tot_new + $total_new;
                $tot_ext = $tot_ext + $total_ext;
                $tot_jum_trans = $tot_trans + $tot_non;
                $pers_non = round((($trans+$non_promo))*100,2);
                $pers_jum = round((($trans+$trans))*100,2);
                $pers_new = round((($trans+$trans_new))*100,2);
                $pers_ext = round((($trans+$trans_ext))*100,2);
            }else if($nama_gym==2||$nama_gym==4){
            $trans = 0;
            $non_promo = 0;
            $trans_new = 0;
            $trans_ext = 0;
            $non_trans = 0;
            $id_gym = DB::table('zonas')->where('id',$title_gyms)->value('id');
            $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
            $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                foreach($gym_ku as $gym_id){
                    $hit_trans = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->count();
                    $hit_non_promo = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id','0')
                            ->count();
                    $hit_trans_new = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Active')
                            ->count();
                    $hit_trans_ext = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Pending')
                            ->count();

                    $id_nonpromo = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('promo_id','0')
                                ->value('package_price_id');
                    $id_trans = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('promo_id',$promos)
                                ->value('package_price_id');
                    $id_new = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Active')
                            ->value('package_price_id');
                    $id_ext = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Pending')
                            ->value('package_price_id');

                    $total_nonpromo = DB::table('package_prices')
                                ->where('package_id',$id_nonpromo)
                                ->value('price');
                    $total_trans = DB::table('package_prices')
                                ->where('package_id',$id_trans)
                                ->value('price');
                    $total_new = DB::table('package_prices')
                                ->where('package_id',$id_new)
                                ->value('price');
                    $total_ext = DB::table('package_prices')
                                ->where('package_id',$id_ext)
                                ->value('price');  

                    $trans = $hit_trans+$hit_trans;  
                    $non_promo = $non_promo+$hit_non_promo;   
                    $trans_new = $trans_new+$hit_trans_new;
                    $trans_ext = $trans_ext+$hit_trans_ext;

                    $tot_non = $tot_trans + $total_nonpromo;
                    $tot_trans = $tot_trans + $total_trans;
                    $tot_new = $tot_new + $total_new;
                    $tot_ext = $tot_ext + $total_ext;
                }
                $jum_trans = $trans + $non_trans;
                $tot_jum_trans = $tot_trans + $tot_non;
                $pers_non = round((($trans+$non_trans))*100,2);
                $pers_jum = round((($trans+$trans))*100,2);
                $pers_new = round((($trans+$trans_new))*100,2);
                $pers_ext = round((($trans+$trans_ext))*100,2);
            }
            ?>
           <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$id_gym}}" aria-expanded="true" aria-controls="collapseOne">
                        @if($nama_gym==2||$nama_gym==4)
                            {{$nama_zona}}
                        @elseif($nama_gym==1||$nama_gym==3)
                            {{$title_gyms}}
                        @endif
                    </a>
                  </h4>
                </div>
                <div id="{{$id_gym}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                            <div class="col-md-6 col-lg-12">
                                        <div class="widget-bg-color-icon card-box fadeInDown animated">
                                            <h3 class="text-dark"><b>Member yang bergabung</b></h3>
                                            <div class="text-right">
                                                <h3 class="text-dark"><b>{{$jum_trans}}</b></h3>
                                                <p class="text-muted">{{$tot_jum_trans}}</p>
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
                                                <h3 class="text-dark"><b>{{$non_promo}}</b></h3>
                                                <p class="text-muted">{{$tot_non}}<br>{{$pers_non}}%<br>Non Promo</p>
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
                                        <h3 class="text-dark"><b>{{$trans}}</b></h3>
                                        <p class="text-muted">{{$tot_trans}}<br>{{$pers_jum}}%<br>Jumlah</p>
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
                                        <h3 class="text-dark"><b>{{$trans_new}}</b></h3>
                                        <p class="text-muted">{{$tot_new}}<br>{{$pers_new}}%<br>Member Baru</p>
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
                                        <h3 class="text-dark"><b>{{$trans_ext}}</b></h3>
                                        <p class="text-muted">{{$tot_ext}}<br>{{$pers_ext}}%<br>Member Perpanjangan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            </div>
    </div>
  </div>
  </div>
            @endforeach 
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
                            @foreach($promo as $promos)
                            <?php 
                            if($nama_gym==null){
                                $trans = 0;
                                $non_promo = 0;
                                $trans_new = 0;
                                $trans_ext = 0;   
                                $jum_trans = 0;  
                                $pers_non = 0;
                                $pers_jum = 0;
                                $pers_new = 0;
                                $pers_ext = 0;   
                            }else{
                                $trans = DB::table('transactions')
                                        ->count();
                                $non_promo = DB::table('transactions')
                                        ->where('promo_id','0')
                                        ->count();
                                $trans_new = DB::table('transactions')
                                        ->where('promo_id',$promos)
                                        ->where('status','Active')
                                        ->count();
                                $trans_ext = DB::table('transactions')
                                        ->where('promo_id',$promos)
                                        ->where('status','Pending')
                                        ->count();   
                                $jum_trans = $trans+$non_promo; 
                                $pers_non = round((($trans+$non_promo))*100,2);
                                $pers_jum = round((($trans+$trans))*100,2);
                                $pers_new = round((($trans+$trans_new))*100,2);
                                $pers_ext = round((($trans+$trans_ext))*100,2);   
                            }       
                            ?>
                            <script>
var data = [
    {
        value: {{$jum_trans}},
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "Member yang Bergabung"
    },
    {
        value: {{$pers_non}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Non Promo"
    },
    {
        value: {{$pers_jum}},
        color: "#FDB45C",
        highlight: "#FFC870",
        label: "Jumlah"
    },
    {
        value: {{$pers_new}},
        color: "#949FB1",
        highlight: "#A8B3C5",
        label: "Member Baru"
    },
    {
        value: {{$pers_ext}},
        color: "#E3F203",
        highlight: "#E3F203",
        label: "Member Perpanjangan"
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
            data : [{{$jum_trans}}]
        },
        {
            fillColor : "#46BFBD",
            strokeColor : "#46BFBD",
            data : [{{$non_promo}}]
        },
        {
            fillColor : "#FDB45C",
            strokeColor : "#FDB45C",
            data : [{{$trans}}]
        },
        {
            fillColor : "#949FB1",
            strokeColor : "#949FB1",
            data : [{{$trans_new}}]
        },
        {
            fillColor : "#E3F203",
            strokeColor : "#E3F203",
            data : [{{$trans_ext}}]
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