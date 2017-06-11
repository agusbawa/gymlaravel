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
                <form action="/u/report/searchusiabarudetail" class="form-inline" method="POST">
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
                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelusiamemberbarudetail"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFusiamemberbarudetail"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
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
                                        <p class="text-muted"><span id="hidden_persen1" style="visibility: hidden;">100%</span><br>Member Baru</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$eight = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen2" style="visibility: hidden;">100%</span><br> > 18 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$eightsatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</b></h3>
                                         <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($eightsatu && $eight){{number_format(($eightsatu/$eight)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                        <p class="text-muted">1 Bulan</p>
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
                                        <h3 class="text-dark"><b>{{$eightdua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($eightdua && $eight){{number_format(($eightdua/$eight)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b>{{$eighttiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($eighttiga && $eight){{number_format(($eighttiga/$eight)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b>{{$eightempat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($eightempat && $eight){{number_format(($eightempat/$eight)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                                </div>
                            </div>

                            

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$twenty = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">0%</span><br>18 - 24 Tahun</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$twentysatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($twentysatu && $twenty){{number_format(($twentysatu/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$twentydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($twentydua && $twenty){{number_format(($twentydua/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$twentytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($twentytiga && $twenty){{number_format(($twentytiga/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$twentypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($twentypat && $twenty){{number_format(($twentypat/$twenty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                              <div class="clearfix"></div>
                             </div>
                            </div>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$eight = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">0%</span><br>25 - 34 Tahun</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$thirtyone = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($thirtyone && $thirty){{number_format(($thirtyone/$thirty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$thirtydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($thirtydua && $thirty){{number_format(($thirtydua/$thirty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$thirtytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($thirtytiga && $thirty){{number_format(($thirtytiga/$thirty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$thirtypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($thirtypat && $thirty){{number_format(($thirtypat/$thirty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fourty = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">100%</span><br>35 - 44 Tahun</p>
                                    </div>
                                    <div class="clearfix"></div>
                                

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$fourtysatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fourtysatu && $fourty){{number_format(($fourtysatu/$fourty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fourtydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fourtydua && $fourty){{number_format(($fourtydua/$fourty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fourtytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fourtytiga && $fourty){{number_format(($fourtytiga/$fourty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fourtypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))
                                        ->get()->count()}}</b></h3>
                                    
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fourtypat && $fourty){{number_format(($fourtytiga/$fourty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$fifty = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">0%</span><br>45 - 54 Tahun</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                              

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$fiftysatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fiftysatu && $fifty){{number_format(($fiftysatu/$fifty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fiftydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fiftydua && $fifty){{number_format(($fiftydua/$fifty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fiftytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fiftytiga && $fifty){{number_format(($fiftytiga/$fifty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$fiftypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($fiftypat && $fifty){{number_format(($fiftypat/$fifty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                             <div class="clearfix"></div>
                              </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$sixty = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">0%</span><br>55 - 64 Tahun</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$sixtysatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($sixtysatu && $sixty){{number_format(($sixtysatu/$sixty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$sixtydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($sixtydua && $sixty){{number_format(($sixtydua/$sixty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$sixtytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($sixtytiga && $sixty){{number_format(($sixtytiga/$sixty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$sixtypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($sixtypat && $sixty){{number_format(($sixtypat/$sixty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            </div>
                            </div>
                           <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{$seventy = App\Member::orderBy('nick_name','asc')->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))->get()->count()}}</b></h3>
                                        <p class="text-muted"><span id="hidden_persen3" style="visibility: hidden;">0%</span><br>65+ Tahun</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">100%</span><br></p>
                                    </div>
                                    <div class="clearfix"></div>
                               

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class="glyphicon glyphicon-user text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>
                                        {{$seventysatu = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','30')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">1 Bulan</p>
                                        <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($seventysatu && $seventy){{number_format(($seventysatu/$severnty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$severntydua = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','90')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">3 Bulan</p>
                                         <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($severntydua && $seventy){{number_format(($seventydua/$severnty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$seventytiga = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','180')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">6 Bulan</p>
                                         <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($seventytiga && $seventy){{number_format(($seventytiga/$severnty)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
                                        <h3 class="text-dark"><b> {{$severntypat = App\Member::orderBy('nick_name','asc')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->where('package_prices.day','365')
                                        ->where('expired_at','>',$currentdate)->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))
                                        ->get()->count()}}</b></h3>
                                        <p class="text-muted">12 Bulan</p>
                                         <p class="text-muted"><span class="persen" style="visibility: hidden;">@if($severntypat && $seventy){{number_format(($severntypat/$seventy)*100,0,'.','')}}@else 0 @endif%</span><br></p>
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
            document.getElementById("hidden_persen1").style.visibility = "visible"; 
            document.getElementById("hidden_persen2").style.visibility = "visible"; 
            document.getElementById("hidden_persen3").style.visibility = "visible"; 
            document.getElementById("hidden_persen4").style.visibility = "visible"; 
            document.getElementById("hidden_persen5").style.visibility = "visible"; 
            document.getElementById("hidden_persen6").style.visibility = "visible"; 
            document.getElementById("hidden_persen7").style.visibility = "visible"; 
            document.getElementById("hidden_persen8").style.visibility = "visible"; 
            var persen = document.getElementsByClassName('persen');
             var i;
             for (i = 0;i < persen.length; i++){
                 persen[i].style.visibility = "visible"; 
             }
        } else {
            document.getElementById("hidden_persen1").style.visibility = "hidden"; 
            document.getElementById("hidden_persen2").style.visibility = "hidden"; 
            document.getElementById("hidden_persen3").style.visibility = "hidden"; 
            document.getElementById("hidden_persen4").style.visibility = "hidden"; 
            document.getElementById("hidden_persen5").style.visibility = "hidden"; 
            document.getElementById("hidden_persen6").style.visibility = "hidden"; 
            document.getElementById("hidden_persen7").style.visibility = "hidden"; 
            document.getElementById("hidden_persen8").style.visibility = "hidden";  
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
      value: {{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->get()->count()}},
      label: 'All Member',
      color: '#811BD6'
   },
   {
      value: {{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
         ->where('package_prices.day','=','30')
         ->get()->count()}},
      label: 'Paket 1 Bulan',
      color: '#8C9BD6'
   },
  
];
var options = {
        tooltipTemplate: "<%= label %> : <%= value %>%"
    }
         var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData,options);
var barData ={
    labels: ["All Member","Paket 1 Bulan"],
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
            data: [{{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
         ->get()->count()}},{{App\Member::orderBy('members.id','DESC')
         ->join('member_histories','member_histories.member_id','=','members.id')
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