@extends('dashboard._layout.dashboard')

@section('help-title', 'Pendapatan member baru')
@section('title', 'Pendapatan member baru')
@section('page-title', 'Pendapatan Member Baru')
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
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option @if($nama_gym==0) selected @endif value="0">Semua</option>
                            <!--<option @if($nama_gym==1) selected @endif value="1">Semua Gym</option>-->
                            <option @if($nama_gym==2) selected @endif value="2">Semua Zona</option>
                            <!--<option @if($nama_gym==3) selected @endif value="3">Gym Tertentu</option>-->
                            <option @if($nama_gym==4) selected @endif value="4">Zona Tertentu</option>
                           <!-- <option @if($nama_gym==5) selected @endif value="5">Gym Dalam Zona Tertentu</option>-->
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
        
    
          <?php
             $pendapatan = App\Transaction::orderBy('transactions.id','asc');
        $total = 0;
        foreach($pendapatan->get() as $trans){
            $total = $total+$trans->total;
        }
        
        
        $baru = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtotal = 0;
         
        $newsatu =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtiga =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        foreach($baru->select('transactions.total')->get() as $new){
            $newtotal = $newtotal + $new->total;
        }
       
       
       $totalnewsatu = 0;
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalnewsatu = $totalnewsatu + $new->total;
        }
        
         
        $totalnewtiga = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalnewtiga = $totalnewtiga + $new->total;
        }
       
        $newempat = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewempat = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewempat = $totalnewempat + $new->total;
        }
        $newlima = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewlima = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewlima = $totalnewlima + $new->total;
        }
//------------------------------------------------------------
        $panjang = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
       
        $totalpanjang = 0;
        $panjangsatu =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $panjangtiga =  App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        foreach($panjang->select('transactions.total')->get() as $new){
            $totalpanjang = $totalpanjang + $new->total;
        }
       
       
       $totalpanjangsatu = 0;
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalpanjangsatu = $totalpanjangsatu + $new->total;
        }
        
         
        $totalpanjangtiga = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalpanjangtiga = $totalpanjangtiga + $new->total;
        }
       
        $panjangempat = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjangempat = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjangempat = $totalpanjangempat + $new->total;
        }
        $panjanglima = App\Transaction::orderBy('transactions.id','asc')->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjanglima = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjanglima = $totalpanjanglima + $new->total;
        }
        $memberharian = App\Memberharian::orderBy('members_harian.id','asc')->join('package_prices','package_prices.id','=','members_harian.package_id')->get();
        $totalharian = 0;
        foreach($memberharian as $harian){
            $totalharian = $totalharian + $harian->total;
        }
        $kantin = App\Kantin::orderBy('kantin.id','asc')->get();
        $totalkantin = 0;
        foreach($kantin as $harian){
            $totalkantin = $totalkantin + $harian->total;
        }
        $personaltrainer = App\Personaltrainer::orderBy('id','asc')->get();
        $totaltrainer = 0;
        foreach($personaltrainer as $harian){
            $totaltrainer = $totaltrainer + $harian->fee_gym;
        }
        $total = $total + $totalharian + $totalkantin +  $totaltrainer;
          ?>
                            
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
        
          <?php
        $date_awal = Carbon\Carbon::parse($backdate)->format('d-m-Y');
        $date_akhir = Carbon\Carbon::parse($currentdate)->format('d-m-Y');
        ?>
        @if($nama_gym==null)

        @else
@foreach ($gyms as $gymku)
            @if($nama_gym==2) 
                        <a href="/u/report/link_zonapendapatan/{{$gymku->id}}?range={{$date_awal}}++-++{{$date_akhir}}">
                      @else
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$gymku->id}}" aria-expanded="true" aria-controls="collapseOne">
                         @endif
             
               <?php 
                 $pendapatan = App\Transaction::orderBy('transactions.id','asc')
                 ->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id);
        $totalgym = 0;
        foreach($pendapatan->get() as $trans){
            $totalgym = $totalgym+$trans->total;
        }
        
        
        $baru = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtotalgym = 0;
         
        $newsatu =  App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $newtiga =  App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        foreach($baru->select('transactions.total')->get() as $new){
            $newtotalgym = $newtotalgym + $new->total;
        }
       
       
       $totalnewsatugym = 0;
        foreach($newsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalnewsatugym = $totalnewsatugym + $new->total;
        }
        
         
        $totalnewtigagym = 0;
        foreach($newtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalnewtigagym = $totalnewtigagym + $new->total;
        }
       
        $newempat = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewempatgym = 0;
        foreach($newempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewempatgym = $totalnewempatgym + $new->total;
        }
        $newlima = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate]);
        $totalnewlimagym = 0;
        foreach($newlima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalnewlimagym = $totalnewlimagym + $new->total;
        }
//------------------------------------------------------------
        $panjang = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
       
        $totalpanjanggym = 0;
        $panjangsatu =  App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $panjangtiga =  App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        foreach($panjang->select('transactions.total')->get() as $new){
            $totalpanjanggym = $totalpanjanggym + $new->total;
        }
       
       
       $totalpanjangsatugym = 0;
        foreach($panjangsatu->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','30')->select('transactions.total')->get() as $new){
            $totalpanjangsatugym = $totalpanjangsatugym + $new->total;
        }
        
         
        $totalpanjangtigagym = 0;
        foreach($panjangtiga->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','90')->select('transactions.total')->get() as $new){
            $totalpanjangtigagym = $totalpanjangtigagym + $new->total;
        }
       
        $panjangempat = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjangempatgym = 0;
        foreach($panjangempat->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjangempatgym = $totalpanjangempatgym + $new->total;
        }
        $panjanglima = App\Transaction::orderBy('transactions.id','asc')->join('gyms','gyms.id','=','transactions.gym_id')->join('zonas','zonas.id','=','gyms.zona_id')->where('zonas.id',$gymku->id)->join('members','members.id','=','transactions.member_id')->join('member_histories','members.id','=','member_histories.member_id')
        ->whereBetween('member_histories.extends',[$backdate,$currentdate]);
        $totalpanjanglimagym = 0;
        foreach($panjanglima->join('package_prices','package_prices.id','=','members.package_id')->where('package_prices.day','180')->select('transactions.total')->get() as $new){
            $totalpanjanglimagym = $totalpanjanglimagym + $new->total;
        }
        $memberharian = App\Memberharian::orderBy('members_harian.id','asc')->join('package_prices','package_prices.id','=','members_harian.package_id')->where('members_harian.gym_id',$gymku->id)->get();
        $totalhariangym = 0;
        foreach($memberharian as $harian){
            $totalhariangym = $totalhariangym + $harian->price;
        }
        $kantin = App\Kantin::orderBy('kantin.id','asc')->where('gym_id',$gymku->id)->get();
        $totalkantingym = 0;
        foreach($kantin as $harian){
            $totalkantingym = $totalkantingym + $harian->total;
        }
        $personaltrainer = App\Personaltrainer::orderBy('id','asc')->where('gym_id',$gymku->id)->get();
        $totaltrainergym = 0;
        foreach($personaltrainer as $harian){
            $totaltrainergym = $totaltrainergym + $harian->fee_gym;
        }
        $totlgym = $totalgym + $totalhariangym + $totalkantingym +  $totaltrainergym;
              ?>
            </a>
          </h4>
        </div>
        <tr>
            <td>{{$gymku->title}}</td>
            <td>{{$totlgym}}<span class="persen" style="visibility: hidden;">@if($totlgym && $total ){{number_format(($totlgym/$total)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{number_format($newtotalgym,0,'.','')}}<span class="persen" style="visibility: hidden;">@if($newtotal && $newtotalgym ){{number_format(($newtotalgym/$newtotal)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalnewsatugym}}<span class="persen" style="visibility: hidden;">@if($totalnewsatu && $totalnewsatugym ){{number_format(($totalnewsatugym/$totalnewsatu)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalnewtigagym}}<span class="persen" style="visibility: hidden;">@if($totalnewtiga && $totalnewtigagym ){{number_format(($totalnewtigagym/$totalnewtiga)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalnewempatgym}}<span class="persen" style="visibility: hidden;">@if($totalnewempat && $totalnewempatgym ){{number_format(($totalnewempatgym/$totalnewempat)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalnewlimagym}}<span class="persen" style="visibility: hidden;">@if($totalnewlima && $totalnewlimagym ){{number_format(($totalnewlimagym/$totalnewlima)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalpanjanggym}}<span class="persen" style="visibility: hidden;">@if($totalpanjang && $totalpanjanggym ){{number_format(($totalpanjanggym/$totalpanjang)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp  {{$totalpanjangsatugym}}<span class="persen" style="visibility: hidden;">@if($totalpanjanggym && $totalpanjangsatugym ){{number_format(($totalpanjangsatugym/$totalpanjanggym)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp  {{$totalpanjangtigagym}}<span class="persen" style="visibility: hidden;">@if($totalpanjanggym && $totalpanjangtigagym ){{number_format(($totalpanjangtigagym/$totalpanjanggym)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp  {{$totalpanjangempatgym}}<span class="persen" style="visibility: hidden;">@if($totalpanjanggym && $totalpanjangempatgym ){{number_format(($totalpanjangempatgym/$totalpanjanggym)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp  {{$totalpanjanglimagym}}<span class="persen" style="visibility: hidden;">@if($totalpanjanggym && $totalpanjanglimagym ){{number_format(($totalpanjanglimagym/$totalpanjanggym)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totalkantingym}}<span class="persen" style="visibility: hidden;">@if($totalkantingym && $totalkantin ){{number_format(($totalkantingym/$totalkantin)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp  {{$totalhariangym}}<span class="persen" style="visibility: hidden;">@if($totalhariangym && $totalharian ){{number_format(($totalhariangym/$totalharian)*100,0,'.','')}}@else 0 @endif%</span></td>
            <td>Rp {{$totaltrainergym}}<span class="persen" style="visibility: hidden;">@if($totaltrainergym && $totaltrainer ){{number_format(($totaltrainergym/$totaltrainer)*100,0,'.','')}}@else 0 @endif%</span></td>
        </tr>
        
       

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
                @endforeach
              @endif
</table>
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