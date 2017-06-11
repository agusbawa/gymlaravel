@extends('dashboard._layout.dashboard')

@section('help-title', 'Rekap Slip Setoran')
@section('title', 'Rekap Slip Setoran')
@section('page-title', 'Rekap Slip Setoran')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchsetoran" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Nama Cabang</label>
                       <select onchange="nilaiTransaksi()" id="valuepayment" name="lokasi" class="select2 form-control">
                    <option value="" selected="">Pilih Lokasi</option>
                    <option value="0">Semua</option>
                @foreach($gym as $gymku)
                    <option value="{{$gymku->id}}">{{$gymku->title}}</option>
                @endforeach
                </select>
                    </div>   
                    <div class="form-group">
                    <label class="control-label">Bulan</label>
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="{{old('range')}}{{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}">
                    </div>

                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelslipsetoran"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFslipsetoran"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                     
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
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#1" aria-expanded="true" aria-controls="collapseOne">
            <?php $gym_nama = DB::table('gyms')->where('id',$nama_gym)->value('title'); ?>
              {{$gym_nama}}
              <?php 
              $setoran_bank = DB::table('setoran_bank')->where('gym_id',$nama_gym)->get(); 
              ?>
            </a>
          </h4>
        </div>
        <div id="1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
          @foreach($setoran_bank as $setoran_banks)
          <?php
                $hit_cash = 0;
                $hit_edc = 0;
                $hit_bsm = 0;
                $pen_cah = DB::table('transactions')->where('gym_id',$nama_gym)->whereBetween('created_at',[$backdate,$currentdate])->where('payment_method','Cash')->pluck('total');
                $pen_edc = DB::table('transactions')->where('gym_id',$nama_gym)->whereBetween('created_at',[$backdate,$currentdate])->where('payment_method','EDC')->pluck('total');
                $pen_bsm = DB::table('setoran_bank')->where('gym_id',$nama_gym)->whereBetween('tgl_stor',[$backdate,$currentdate])->pluck('total');
                foreach ($pen_cah as $pen_cahs) {
                    $hit_cash = $hit_cash + $pen_cahs; 
                }
                foreach ($pen_edc as $pen_edcs) {
                    $hit_edc = $hit_edc + $pen_edcs; 
                }
                foreach ($pen_bsm as $pen_bsms) {
                    $hit_bsm = $hit_bsm + $pen_bsms; 
                }
            ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-dark"><b>{{$hit_cash}} </b></h4>
                                        <p class="text-muted">Jumlah Pendapatan Cash</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-dark"><b>{{$hit_edc}}</b></h4>
                                        <p class="text-muted">Jumlah Pendapatan EDC</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-dark"><b>{{Carbon\Carbon::parse($setoran_banks->tgl_stor)->format('d-m-Y')}}</b></h4>
                                        <p class="text-muted">Tanggal<br>Setor</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h4 class="text-dark"><b>{{$hit_bsm}}</b></h4>
                                        <p class="text-muted">Jumlah Setoran BSM</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                         @endforeach
                            </div>
                        </div>
                      </div>
                    </div>

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
      @foreach ($gyms as $gym)
   {
      value: 80,
      label: '{{$gym->title}}',
      color: '#811BD6'
   },
    @endforeach
  
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
                'rgba(255, 99, 132, 0.2)'
                
            ],
            borderColor: [
                'rgba(255,99,132,1)'
               
            ],
            borderWidth: 1,
            data: [80],
        }
    ]
}
var context = document.getElementById('bar').getContext('2d');
var skillsChart = new Chart(context).Bar(barData);
</script>
<br/>
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