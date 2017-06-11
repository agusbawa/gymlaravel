@extends('dashboard._layout.dashboard')

@section('help-title', 'Register Member Baru')
@section('title', 'Register Member Baru')
@section('page-title', 'Usia Member')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchusiabaruvs" class="form-inline" method="POST">
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
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>
                    <div class="form-group checkbox">
                        <input name="onlineMember" type="checkbox" class="checkboxId" onclick="calc();"> 
                        <label for="checkbox0">
                            Tampilkan %
                        </label>
                    </div>
                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelusiamemberbaruvs"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFusiamemberbaruvs"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
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
<div class="panel panel-default">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Semua
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
                        <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                   
                                    <div class="text-center">
                                        <h3 class="text-dark"><b>{{$all=App\Member::where('expired_at','>',$currentdate)->get()->count()}}</b></h3>
                                        <p class="text-dark">Member Expired</p>    
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$eight=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))
                                       ->get()->count()}}</b></h3>
                                         <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($eight && $all){{number_format(($eight/$all)*100,0,'.','')}}@else 0 @endif%</span><br>> 18 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$oleight=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($oleight && $eight){{number_format(($oleight/$eight)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$ofeight=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                       
                                        <p class="text-muted">CS</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($ofeight && $eight){{number_format(($eight/$all)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>

                            

                             <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$twenty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-24))
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($twenty && $all){{number_format(($twenty/$all)*100,0,'.','')}}@else 0 @endif%</span><br>18-24 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$oltwenty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-24))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($oltwenty && $twenty){{number_format(($oltwenty/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$oftwenty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-24))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($oftwenty && $twenty){{number_format(($oftwenty/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$thirty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-34))
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($thirty && $all){{number_format(($thirty/$all)*100,0,'.','')}}@else 0 @endif%</span><br>25-34 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$olthirty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-34))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($olthirty && $thirty){{number_format(($olthirty/$thirty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$ofthirty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-34))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($ofthirty && $thirty){{number_format(($ofthirty/$all)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>
                             <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fourty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-44))
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fourty && $all){{number_format(($fourty/$all)*100,0,'.','')}}@else 0 @endif%</span><br> 35 - 44 Tahun</p>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$olfourty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-34))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($olfourty && $fourty){{number_format(($olfourty/$fourt)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$offourty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-34))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($offourty && $fourty){{number_format(($ofthirty/$all)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>
 

                             <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fifty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-54))
                                       
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fifty && $all){{number_format(($fifty/$all)*100,0,'.','')}}@else 0 @endif%</span><br> 45 - 54 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$olfifty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-54))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <span class="persen" style="visibility: hidden;">@if($olfifty && $fifty){{number_format(($olfifty/$fifty)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$offifty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-54))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <span class="persen" style="visibility: hidden;">@if($offifty && $fifty){{number_format(($offifty/$fifty)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$sixty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-64))
                                       
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($sixty && $all){{number_format(($sixty/$all)*100,0,'.','')}}@else 0 @endif%</span><br> 55 - 64 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$olsixty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-64))
                                        ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <span class="persen" style="visibility: hidden;">@if($olsixty && $sixty){{number_format(($olsixty/$sixty)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$ofsixty=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-64))
                                        ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <span class="persen" style="visibility: hidden;">@if($ofsixty && $sixty){{number_format(($ofsixty/$sixty)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$seventy=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                       
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($seventy && $all){{number_format(($seventy/$all)*100,0,'.','')}}@else 0 @endif%</span><br> 65+ Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$olseventy=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                       ->where('registerfrom','1')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">Online</p>
                                        <span class="persen" style="visibility: hidden;">@if($olseventy && $seventy){{number_format(($olseventy/$seventy)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$ofseventy=App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                       ->where('registerfrom','0')
                                       ->get()->count()}}</b></h3>
                                        <p class="text-muted">CS</p>
                                        <span class="persen" style="visibility: hidden;">@if($ofseventy && $seventy){{number_format(($ofseventy/$seventy)*100,0,'.','')}}@else 0 @endif%</span>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
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
   {
      value: 100,
      label: 'All Member',
      color: '#811BD6'
   },
  
  
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
         var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData,options);
var barData ={
    labels: ["All Member"],
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
            data: [{{App\Member::where('expired_at','>',$currentdate)
                                        ->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))
                                       ->get()->count()}}],
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