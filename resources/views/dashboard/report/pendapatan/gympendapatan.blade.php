@extends('dashboard._layout.dashboard')

@section('help-title', 'Report Pendapatan')
@section('title', 'Report Pendapatan')
@section('page-title', 'Report Pendapatan gym')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('membership')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left">
                <form action="/u/report/income" class="form-inline" method="GET">

                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                            
                            <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                           
                            <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                            
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

                    <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelpendapatan"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                    <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFpendapatan"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>

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
                                <select name="zonas[]" id="" multiple="multiple" class="select2" placeholder="Silakan Pilih Nama Zona">
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

    <div class="panel panel-default table-responsive" style="text-align:center; overflow:auto;" >
        <table class="table table-bordered" >
        <tr>
            <th rowspan="2">Lokasi</th>
            <th rowspan="2" class="text-center">Pendapatan <br/>Rp {{$total}}<div class="persen" style="visibility:hidden;">@if($total )
                                            {{number_format(($total/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
            <th colspan="5" class="text-center">Baru <br/> Rp {{$newtotal}}<div class="persen" style="visibility:hidden;">@if($total && $newtotal)
                                            {{number_format(($newtotal/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
            <th colspan="5" class="text-center">Perpanjang <br/> Rp {{$totalpanjang}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $total)
                                            {{number_format(($totalpanjang/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
            <th rowspan="2" class="text-center">Kantin <br/>Rp {{$totalkantin}}<div class="persen" style="visibility:hidden;">@if($totalkantin && $total)
                                            {{number_format(($totalkantin/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
            <th rowspan="2" class="text-center">Pendapatan&nbsp;Harian<br/> Rp  {{$totalharian}}<div class="persen" style="visibility:hidden;">@if($totalharian && $total)
                                            {{number_format(($totalharian/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
            <th rowspan="2" class="text-center">Personal&nbsp;Trainer <br/> Rp {{$totaltrainer}}<div class="persen" style="visibility:hidden;">@if($totaltrainer && $total)
                                            {{number_format(($totaltrainer/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></th>
        </tr>
        <tr class="text-center">
        <td>Jumlah </td>
        <td>Paket&nbsp;1&nbsp;Bulan <br/>Rp {{$totalnewsatu}}<div class="persen" style="visibility:hidden;">@if($newtotal && $totalnewsatu)
                                            {{number_format(($totalnewsatu/$newtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;3&nbsp;Bulan <br/>Rp {{$totalnewtiga}}<div class="persen" style="visibility:hidden;">@if($newtotal && $totalnewtiga)
                                            {{number_format(($totalnewtiga/$newtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;6&nbsp;Bulan <br/> Rp {{$totalnewempat}}<div class="persen" style="visibility:hidden;">@if($newtotal && $totalnewempat)
                                            {{number_format(($totalnewempat/$newtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;12&nbsp;Bulan <br/> Rp {{$totalnewlima}} <div class="persen" style="visibility:hidden;">@if($newtotal && $totalnewlima)
                                            {{number_format(($totalnewlim/$newtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Jumlah </td>
         <td>Paket&nbsp;1&nbsp;Bulan <br/> Rp  {{$totalpanjangsatu}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $totalpanjangsatu)
                                            {{number_format(($totalpanjangsatu/$totalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;3&nbsp;Bulan <br/> Rp  {{$totalpanjangtiga}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $totalpanjangtiga)
                                            {{number_format(($totalpanjangtiga/$totalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;6&nbsp;Bulan <br/> Rp  {{$totalpanjangempat}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $totalpanjangempat)
                                            {{number_format(($totalpanjangempat/$totalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Paket&nbsp;12&nbsp;Bulan <br/> Rp  {{$totalpanjanglima}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $totalpanjanglima)
                                            {{number_format(($totalpanjanglima/$totalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        </tr>
        
    @foreach($gym as $gy)
    <?php
        $pendapatan = App\Transaction::orderBy('transactions.id','asc')
        ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('transactions.created_at',[$backdate,$currentdate]);
        $zonatotal = 0;
        foreach($pendapatan->get() as $trans){
            $zonatotal = $zonatotal+$trans->total;
        }
        
        
        $baru = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $zonanewtotal = 0;
         
        $newsatu =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtiga =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        foreach($baru->select('transactions.total')->get() as $new){
            $zonanewtotal = $zonanewtotal + $new->total;
        }
       
       
       $zonatotalnewsatu = 0;
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $zonatotalnewsatu = $zonatotalnewsatu + $new->total;
        }
        
         
        $zonatotalnewtiga = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $zonatotalnewtiga = $zonatotalnewtiga + $new->total;
        }
       
        $newempat = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $zonatotalnewempat = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $zonatotalnewempat = $zonatotalnewempat + $new->total;
        }
        $newlima = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $zonatotalnewlima = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $zonatotalnewlima = $zonatotalnewlima + $new->total;
        }
//------------------------------------------------------------
        $panjang = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
       
        $zonatotalpanjang = 0;
        $panjangsatu =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $panjangtiga =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        foreach($panjang->select('transactions.total')->get() as $new){
            $zonatotalpanjang = $zonatotalpanjang + $new->total;
        }
       
       
       $zonatotalpanjangsatu = 0;
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $zonatotalpanjangsatu = $zonatotalpanjangsatu + $new->total;
        }
        
         
        $zonatotalpanjangtiga = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $zonatotalpanjangtiga = $zonatotalpanjangtiga + $new->total;
        }
       
        $panjangempat = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $zonatotalpanjangempat = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $zonatotalpanjangempat = $zonatotalpanjangempat + $new->total;
        }
        $panjanglima = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
         ->join('gyms','gyms.id','=','transactions.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $zonatotalpanjanglima = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $zonatotalpanjanglima = $zonatotalpanjanglima + $new->total;
        }
        $memberharian = App\Memberharian::orderBy('members_harian.id','asc')->join('package_prices','package_prices.id','=','members_harian.package_id') ->join('gyms','gyms.id','=','members_harian.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)->get();
        $zonatotalharian = 0;
        foreach($memberharian as $harian){
            $zonatotalharian = $zonatotalharian + $harian->price;
        }
        $kantin = App\Kantin::orderBy('kantin.id','asc') ->join('gyms','gyms.id','=','kantin.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)->get();
        $zonatotalkantin = 0;
        foreach($kantin as $harian){
            $zonatotalkantin = $zonatotalkantin + $harian->total;
        }
        $personaltrainer = App\Personaltrainer::orderBy('personal_trainer.id','asc')
         ->join('gyms','gyms.id','=','personal_trainer.gym_id')
        ->join('zonas','zonas.id','=','gyms.zona_id')
        ->where('zonas.id',$gy->id)->get();
        $zonatotaltrainer = 0;
        foreach($personaltrainer as $harian){
            $zonatotaltrainer = $zonatotaltrainer + $harian->fee_gym;
        }
        $zonatotal = $zonatotal + $zonatotalharian + $zonatotalkantin +  $zonatotaltrainer;
    ?>
    <tr>
        <td>{{$gy->title}}</td>
        <td>Rp&nbsp;{{$zonatotal}}<div class="persen" style="visibility:hidden;">@if($zonatotal && $total)
                                            {{number_format(($zonatotal/$total)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonanewtotal}}<div class="persen" style="visibility:hidden;">@if($zonanewtotal && $newtotal)
                                            {{number_format(($zonanewtotal/$newtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalnewsatu}}<div class="persen" style="visibility:hidden;">@if($zonatotalnewsatu && $zonanewtotal)
                                            {{number_format(($zonatotalnewsatu/$zonanewtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalnewtiga}}<div class="persen" style="visibility:hidden;">@if($zonanewtotal && $zonatotalnewtiga)
                                            {{number_format(($zonatotalnewtiga/$zonanewtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalnewempat}}<div class="persen" style="visibility:hidden;">@if($zonanewtotal && $zonatotalnewempat)
                                            {{number_format(($zonatotalnewempat/$zonanewototal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalnewlima}}<div class="persen" style="visibility:hidden;">@if($zonanewtotal && $zonatotalnewlima)
                                            {{number_format(($zonatotalnewlima/$zonanewtotal)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalpanjang}}<div class="persen" style="visibility:hidden;">@if($totalpanjang && $zonatotalpanjang)
                                            {{number_format(($zonatotalpanjang/$totalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalpanjangsatu}}<div class="persen" style="visibility:hidden;">@if($zonatotalpanjang && $zonatotalpanjangsatu)
                                            {{number_format(($zonatotalpanjangsatu/$zonatotalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalpanjangtiga}}<div class="persen" style="visibility:hidden;">@if($zonatotalpanjang && $zonatotalpanjangtiga)
                                            {{number_format(($zonatotalpanjangtiga/$zonatotalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalpanjangempat}}<div class="persen" style="visibility:hidden;">@if($zonatotalpanjang && $zonatotalpanjangempat)
                                            {{number_format(($zonatotalpanjangempat/$zonatotalpanjangempat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
        <td>Rp&nbsp;{{$zonatotalpanjanglima}}<div class="persen" style="visibility:hidden;">@if($zonatotalpanjang && $zonatotalpanjanglima)
                                            {{number_format(($zonatotalpnajanglima/$zonatotalpanjang)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
         <td>Rp&nbsp;{{$zonatotalkantin}}<div class="persen" style="visibility:hidden;">@if($zonatotalkantin && $totalkantin)
                                            {{number_format(($zonatotalkantin/$totalkantin)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
         <td>Rp&nbsp;{{$zonatotalharian}}<div class="persen" style="visibility:hidden;">@if($zonatotalharian && $totalharian)
                                            {{number_format(($zonatotalharian/$totalharian)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
           <td>Rp&nbsp;{{$zonatotaltrainer}}<div class="persen" style="visibility:hidden;">@if($zonatotaltrainer && $totaltrainer)
                                            {{number_format(($zonatotaltrainer/$totaltrainer)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif</div></td>
       
    </tr>
   
@endforeach
</table>
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