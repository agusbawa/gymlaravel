@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Member Baru (Perbandingan Periodik)')

@section('content')
<div class="row">
    <div class="col-md-10" style="margin-bottom: 10px;">
        <form action="/u/report/newextendsyear" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Lokasi</label>
                <select name="nama_gym" class="select2 form-control" onchange="showDiv(this)">
                    <option value="">Pilih Lokasi</option>
                    <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                    <option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>
                    <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                    <option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>
                    <option @if($nama_gym==4) selected @endif  value="4">Zona Tertentu</option>
                    <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>
                </select>
            <label>Tahun</label>
                <select id="valuepayment" name="tahun_gym" class="select2 form-control">
                    <option value="" selected="">Pilih Tahun</option>
                    <?php for ($thn=2014; $thn<=2050; $thn++){ ?>
                       <option value="<?php echo $thn ?>" <?php if($tahun_gym==$thn){ print ' selected'; }?>><?php echo $thn ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group checkbox">
                <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                <label for="checkbox0">
                    Tampilkan %
                </label>
            </div>

            @if($nama_gym==1||$nama_gym==3)
            <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
            <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            @elseif($nama_gym==2||$nama_gym==4)
            <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentuzona as $tent)&zonasku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
            <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentuzona as $tent)&zonasku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            @elseif($nama_gym==5)
            <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentuzona as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
            <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFnewextendsyear/search?nama_gym={{$nama_gym}}&tahun_gym={{$tahun_gym}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            @endif

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
	
            @if($nama_gym==null)

            @else
                @foreach($title_gym as $title_gyms)

                <?php 
                 if($nama_gym==1||$nama_gym==3||$nama_gym==5){
                    $gym_id = DB::table('gyms')->where('title',$title_gyms)->value('id');             
                    $new = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'%')
                                    ->count();
                    $jan = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-01%')
                                    ->count();
                    $feb = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-02%')
                                    ->count();
                    $mar = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-03%')
                                    ->count();
                    $apr = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-04%')
                                    ->count();
                    $mei = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-05%')
                                    ->count();
                    $jun = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-06%')
                                    ->count();
                    $jul = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-07%')
                                    ->count();
                    $agu = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-08%')
                                    ->count();
                    $sep = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-09%')
                                    ->count();
                    $oct = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-10%')
                                    ->count();
                    $nov = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-11%')
                                    ->count();
                    $des = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->where('new_register','like',$tahun_gym.'-12%')
                                    ->count();
                }else if($nama_gym==2||$nama_gym==4){
                    $new = 0;
                    $jan = 0;
                    $feb = 0;
                    $mar = 0;
                    $apr = 0;
                    $mei = 0;
                    $jun = 0;
                    $jul = 0;
                    $agu = 0;
                    $sep = 0;
                    $oct = 0;
                    $nov = 0;
                    $des = 0;
                    $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    $gym_ids = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id'); 
                        foreach ($gym_ids as $gym_id) {            
                            $hit_new = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'%')
                                            ->count();
                            $hit_jan = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-01%')
                                            ->count();
                            $hit_feb = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-02%')
                                            ->count();
                            $hit_mar = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-03%')
                                            ->count();
                            $hit_apr = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-04%')
                                            ->count();
                            $hit_mei = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-05%')
                                            ->count();
                            $hit_jun = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-06%')
                                            ->count();
                            $hit_jul = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-07%')
                                            ->count();
                            $hit_agu = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-08%')
                                            ->count();
                            $hit_sep = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-09%')
                                            ->count();
                            $hit_oct = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-10%')
                                            ->count();
                            $hit_nov = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-11%')
                                            ->count();
                            $hit_des = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->where('new_register','like',$tahun_gym.'-12%')
                                            ->count();
                            $new = $new + $hit_new;
                            $jan = $jan + $hit_jan;
                            $feb = $feb + $hit_feb;
                            $mar = $mar + $hit_mar;
                            $apr = $apr + $hit_apr;
                            $mei = $mei + $hit_mei;
                            $jun = $jun + $hit_jun;
                            $jul = $jul + $hit_jul;
                            $agu = $agu + $hit_agu;
                            $sep = $sep + $hit_sep;
                            $oct = $oct + $hit_oct;
                            $nov = $nov + $hit_nov;
                            $des = $des + $hit_des;
                    }
                }
                $per_new = round((($new/3563)*100),2);
                $per_jan = round((($jan/259)*100),2);
                $per_feb = round((($feb/302)*100),2);
                $per_mar = round((($mar/360)*100),2);
                $per_apr = round((($apr/253)*100),2);
                $per_mei = round((($mei/261)*100),2);
                $per_jun = round((($jun/388)*100),2);
                $per_jul = round((($jul/284)*100),2);
                $per_agu = round((($agu/304)*100),2);
                $per_sep = round((($sep/292)*100),2);
                $per_oct = round((($oct/286)*100),2);
                $per_nov = round((($nov/296)*100),2);
                $per_des = round((($des/278)*100),2);
                ?>
                    
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        @if($nama_gym==2) 
                        <a href="/u/report/newextendsyear/{{$title_gyms}}?tahun_gym={{$tahun_gym}}">
                      @else
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gym_id}}" aria-expanded="true" aria-controls="collapseOne">
                         @endif
          @if($nama_gym==2||$nama_gym==4)
                    {{$nama_zona}}
                    @elseif($nama_gym==1||$nama_gym==3||$nama_gym==5)
                    {{$title_gyms}}
                    @endif
        </a>
      </h4>
    </div>
    <div id="{{$gym_id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$new}}<br><span class="text-muted" id="hidden_persen1{{$gym_id}}" style="visibility: hidden;">{{$per_new}}%</span></b></h3>
                                        <p class="text-muted">Perpanjangan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jan}}<br><span class="text-muted" id="hidden_persen2{{$gym_id}}" style="visibility: hidden;">{{$per_jan}}%</span></b></h3>
                                        <p class="text-muted">Januari</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$feb}}<br><span class="text-muted" id="hidden_persen3{{$gym_id}}" style="visibility: hidden;">{{$per_feb}}%</span></b></h3>
                                        <p class="text-muted">Februari</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$mar}}<br><span class="text-muted" id="hidden_persen4{{$gym_id}}" style="visibility: hidden;">{{$per_mar}}%</span></b></h3>
                                        <p class="text-muted">Maret</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$apr}}<br><span class="text-muted" id="hidden_persen5{{$gym_id}}" style="visibility: hidden;">{{$per_apr}}%</span></b></h3>
                                        <p class="text-muted">April</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$mei}}<br><span class="text-muted" id="hidden_persen6{{$gym_id}}" style="visibility: hidden;">{{$per_mei}}%</span></b></h3>
                                        <p class="text-muted">Mei</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jun}}<br><span class="text-muted" id="hidden_persen7{{$gym_id}}" style="visibility: hidden;">{{$per_jun}}%</span></b></h3>
                                        <p class="text-muted">Juni</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$jul}}<br><span class="text-muted" id="hidden_persen8{{$gym_id}}" style="visibility: hidden;">{{$per_jul}}%</span></b></h3>
                                        <p class="text-muted">Juli</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$agu}}<br><span class="text-muted" id="hidden_persen9{{$gym_id}}" style="visibility: hidden;">{{$per_agu}}%</span></b></h3>
                                        <p class="text-muted">Agustus</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$sep}}<br><span class="text-muted" id="hidden_persen10{{$gym_id}}" style="visibility: hidden;">{{$per_sep}}%</span></b></h3>
                                        <p class="text-muted">September</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$oct}}<br><span class="text-muted" id="hidden_persen11{{$gym_id}}" style="visibility: hidden;">{{$per_oct}}%</span></b></h3>
                                        <p class="text-muted">Oktober</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>    

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$nov}}<br><span class="text-muted" id="hidden_persen12{{$gym_id}}" style="visibility: hidden;">{{$per_nov}}%</span></b></h3>
                                        <p class="text-muted">November</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>    

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class="glyphicon glyphicon-user text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$des}}<br><span class="text-muted" id="hidden_persen13{{$gym_id}}" style="visibility: hidden;">{{$per_des}}%</span></b></h3>
                                        <p class="text-muted">Desember</p>
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
            document.getElementById("hidden_persen1{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen2{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen3{{$gym_id}}").style.visibility = "visible";
            document.getElementById("hidden_persen4{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen5{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen6{{$gym_id}}").style.visibility = "visible";
            document.getElementById("hidden_persen7{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen8{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen9{{$gym_id}}").style.visibility = "visible";
            document.getElementById("hidden_persen10{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen11{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen12{{$gym_id}}").style.visibility = "visible"; 
            document.getElementById("hidden_persen13{{$gym_id}}").style.visibility = "visible"; 
        } else {
            document.getElementById("hidden_persen1{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3{{$gym_id}}").style.visibility = "hidden";
            document.getElementById("hidden_persen4{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen5{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen6{{$gym_id}}").style.visibility = "hidden";
            document.getElementById("hidden_persen7{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen8{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen9{{$gym_id}}").style.visibility = "hidden";
            document.getElementById("hidden_persen10{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen11{{$gym_id}}").style.visibility = "hidden"; 
            document.getElementById("hidden_persen12{{$gym_id}}").style.visibility = "hidden";
            document.getElementById("hidden_persen13{{$gym_id}}").style.visibility = "hidden";
        }
    });
</script> 
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
                            $color = substr(md5(rand()), 0, 6);
                            if($nama_gym==1){
                    $gym_id = DB::table('gyms')->where('title',$title_gyms)->value('id');
                }else{
                    $gym_id = DB::table('gyms')->where('zona_id',$title_gyms)->value('id');
                }

                $jan = DB::table('member_histories')
                                ->where('new_register','like',$tahun_gym.'-01%')
                                ->count();
                $feb = DB::table('member_histories')
                                ->where('new_register','like',$tahun_gym.'-02%')
                                ->count();
                $mar = DB::table('member_histories')
                                ->where('new_register','like',$tahun_gym.'-03%')
                                ->count();
                $apr = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-04%')
                                ->count();
                $mei = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-05%')
                                ->count();
                $jun = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-06%')
                                ->count();
                $jul = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-07%')
                                ->count();
                $agu = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-08%')
                                ->count();
                $sep = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-09%')
                                ->count();
                $oct = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-10%')
                                ->count();
                $nov = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-11%')
                                ->count();
                $des = DB::table('member_histories')
                                ->where('gym_id',$gym_id)
                                ->where('new_register','like',$tahun_gym.'-12%')
                                ->count();
                $per_jan = round((($jan/259)*100),2);
                $per_feb = round((($feb/302)*100),2);
                $per_mar = round((($mar/360)*100),2);
                $per_apr = round((($apr/253)*100),2);
                $per_mei = round((($mei/261)*100),2);
                $per_jun = round((($jun/388)*100),2);
                $per_jul = round((($jul/284)*100),2);
                $per_agu = round((($agu/304)*100),2);
                $per_sep = round((($sep/292)*100),2);
                $per_oct = round((($oct/286)*100),2);
                $per_nov = round((($nov/296)*100),2);
                $per_des = round((($des/278)*100),2);
                            ?>
                            <script>
var data = [
    {
        value: {{$per_jan}},
        color:"#F7464A",
        highlight: "#FF5A5E",
        label: "Januari"
    },
    {
        value: {{$per_feb}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Februari"
    },
    {
        value: {{$per_mar}},
        color: "#E3F203",
        highlight: "#E3F203",
        label: "Maret"
    },
    {
        value: {{$per_apr}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "April"
    },
    {
        value: {{$per_mei}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Mei"
    },
    {
        value: {{$per_jun}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Juni"
    },
    {
        value: {{$per_jul}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Juli"
    },
    {
        value: {{$per_agu}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Agustus"
    },
    {
        value: {{$per_sep}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "September"
    },
    {
        value: {{$per_oct}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Oktober"
    },
    {
        value: {{$per_nov}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "November"
    },
    {
        value: {{$per_des}},
        color: "#46BFBD",
        highlight: "#5AD3D1",
        label: "Desember"
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
            data : [{{$jan}}]
        },
        {
            fillColor : "#46BFBD",
            strokeColor : "#5AD3D1",
            data : [{{$feb}}]
        },
        {
            fillColor : "#7FFF00",
            strokeColor : "#7FFF00",
            data : [{{$mar}}]
        },
        {
            fillColor : "#D2691E",
            strokeColor : "#D2691E",
            data : [{{$apr}}]
        },
        {
            fillColor : "#FF7F50",
            strokeColor : "#FF7F50",
            data : [{{$mei}}]
        },
        {
            fillColor : "#6495ED",
            strokeColor : "#6495ED",
            data : [{{$jun}}]
        },
        {
            fillColor : "#FFF8DC",
            strokeColor : "#FFF8DC",
            data : [{{$jul}}]
        },
        {
            fillColor : "#FFF8DC",
            strokeColor : "#FFF8DC",
            data : [{{$agu}}]
        },
        {
            fillColor : "#DC143C",
            strokeColor : "#DC143C",
            data : [{{$sep}}]
        },
        {
            fillColor : "#00FFFF",
            strokeColor : "#00FFFF",
            data : [{{$oct}}]
        },
        {
            fillColor : "#00008B",
            strokeColor : "#00008B",
            data : [{{$nov}}]
        },
        {
            fillColor : "#008B8B",
            strokeColor : "#008B8B",
            data : [{{$des}}]
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