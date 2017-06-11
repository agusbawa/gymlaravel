@extends('dashboard._layout.dashboard')

@section('help-title', 'Membership')
@section('title', 'Membership')
@section('page-title', 'Membership')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/searchpendapatan" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="form-control" placeholder="Gym">
                            <option value="0">Semua</option>
                            <option value="1">Member baru</option>
                            <option value="2">Member Perpanjangan</option>
                            <option value="3">Klasifikasi cara bayar<pembayaran></pembayaran></option>
                        </select>
                    </div>   
                    <div class="form-group">
                    <label class="control-label">Periode</label>
                        <input type="text" class="form-control input-daterange-datepicker" name="range" value="">
                    </div>
                     
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
                    </div>
                    <div class="form-group">
                            <div class="checkbox checkbox-primary">
	                            <input id="checkbox1" type="checkbox">
	                                <label for="checkbox1">
                                            Tampilkan (%)
	                                </label>
	                        </div>
                    </div>
                   <div class="btn-group">
                        <button type="button" class="btn btn-white waves-effect" title="Table"><i class="fa fa-table"></i></button>
                        <button type="button" class="btn btn-white waves-effect" title="Pie chart"><i class="fa fa-pie-chart"></i></button>
                        <button type="button" class="btn btn-white waves-effect" title="Bar chart"><i class="fa fa-bar-chart-o"></i></button>
                    </div>
                </form>
                
            </div>
        </div>
        <br/>
<div class="panel panel-default">
                  
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

         var context = document.getElementById('skills').getContext('2d');
         var skillsChart = new Chart(context).Pie(pieData);
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
</script>

@endsection