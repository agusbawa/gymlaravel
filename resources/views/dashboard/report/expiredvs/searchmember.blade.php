    @extends('dashboard._layout.dashboard')

@section('help-title', 'Member Expired')
@section('title', 'Member Expired')
@section('page-title', 'Member Expired')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('filter')!!}
@endsection
@section('content')
<div class="row">
           
            <div class="col-md-12 text-left" style="margin-bottom: 10px;">
                <form action="/u/report/expiredvssearch" class="form-inline" method="POST">
                {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                    <label class="control-label">Lokasi</label>
                        <select name="lokasi" class="select2 form-control" placeholder="Gym" onchange="showDiv(this)">
                            <option value="">Pilih Lokasi</option>
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

                    @if($nama_gym==5)
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMemberBaruvs/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMemberBaruvs/search?lokasi={{$nama_gym}}@foreach($tertentugymku as $tent)&gymku[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                    @else
                        <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelMemberBaruvs/search?lokasi={{$nama_gym}}&range={{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
                        <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFMemberBaruvs/search?lokasi={{$nama_gym}}@foreach($tertentugym as $tent)&gyms[]={{$tent}}@endforeach"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
                    @endif

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

 <div class="panel panel-default table-responsive" style="text-align:center; overflow:auto;" >
    <table class="table table-bordered text-center" >
        <tr>
            <th rowspan="2">Lokasi</th>
            <th colspan="3" class="text-center">Baru<br/>{{$all = App\Member::orderBy('members.id','DESC')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($all && $all)
                                            {{number_format(($all/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
            <th colspan="3" class="text-center">Paket 1 Bulan<br/>{{$allsatu = App\Member::orderBy('members.id','DESC')
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allsatu && $all)
                                            {{number_format(($allsatu/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
            <th colspan="3" class="text-center">Paket 3 Bulan<br/>{{$alldua = App\Member::orderBy('members.id','DESC')
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($alldua && $all)
                                            {{number_format(($alldua/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
            <th colspan="3" class="text-center">Paket 6 Bulan<br/>{{$alltiga = App\Member::orderBy('members.id','DESC')
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($alltiga && $all)
                                            {{number_format(($alltiga/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
            <th colspan="3" class="text-center">Paket 12 Bulan<br/>{{$allempat = App\Member::orderBy('members.id','DESC')
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allempat && $all)
                                            {{number_format(($allempat/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></th>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td>Online<br/>{{$all = App\Member::orderBy('members.id','DESC')
                                        ->where('members.registerfrom','1')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($all && $all)
                                            {{number_format(($all/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
            <td>CS<br/>{{$all = App\Member::orderBy('members.id','DESC')
                                        ->where('members.registerfrom','0')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($all && $all)
                                            {{number_format(($all/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <!--paketsatu-->
          <td>Jumlah</td>
            <td>Online<br/>{{$onlinesatu = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','1')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allsatu && $onlinesatu)
                                            {{number_format(($onlinesatu/$allsatu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
            <td>CS<br/>{{$csatu = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','0')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($csatu && $allsatu)
                                            {{number_format(($csatu/$allsatu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
                                         <!--paketdua-->
          <td>Jumlah</td>
            <td>Online<br/>{{$onlinedua = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','1')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($onlinedua && $alldua)
                                            {{number_format(($onlinedua/$alldua)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
            <td>CS<br/>{{$csdua = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','0')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($csdua && $alldua)
                                            {{number_format(($csdua/$alldua)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
          <!--paketiga-->
          <td>Jumlah</td>
            <td>Online<br/>{{$onlinetiga = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','1')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($onlinetiga && $alltiga)
                                            {{number_format(($onlinetiga/$alltiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
            <td>CS<br/>{{$cstiga = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','0')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($cstiga && $alltiga)
                                            {{number_format(($cstiga/$alltiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
          <!--paketsatu-->
          <td>Jumlah</td>
            <td>Online<br/>{{$onlinempat = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','1')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($onlinempat && $allempat)
                                            {{number_format(($onlinempat/$allempat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
            <td>CS<br/>{{$csempat = App\Member::orderBy('members.id','DESC')
                                         ->where('members.registerfrom','0')
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($csempat && $allempat)
                                            {{number_format(($csempat/$allempat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        </tr>
        @foreach ($gyms as $gym)
        <tr>
            <td>{{$gym->title}}</td>
            <td>{{$allzona = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allzona && $all)
                                            {{number_format(($allzona/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
          <td>{{$allonline = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',1)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allonline && $allzona)
                                            {{number_format(($allonline/$allzona)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
          <td>{{$allcs = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',0)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($allcs && $allzona)
                                            {{number_format(($allcs/$all)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <td>{{$satu = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($satu && $allsatu)
                                            {{number_format(($satu/$allsatu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <td>{{$satuonline = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',1)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($satu && $satuonline)
                                            {{number_format(($satuonline/$satu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
      <td>{{$satucs = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',0)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','30')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($satu && $satucs)
                                            {{number_format(($satucs/$satu)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
     <td>{{$dua = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($dua && $alldua)
                                            {{number_format(($dua/$alldua)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <td>{{$duaonline = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',1)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($dua && $duaonline)
                                            {{number_format(($dua/$duaonline)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
      <td>{{$duacs = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',0)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','90')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($duacs && $dua)
                                            {{number_format(($duacs/$dua)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>

      <td>{{$tiga = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($tiga && $alltiga)
                                            {{number_format(($tiga/$alltiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <td>{{$tigaonline = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',1)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($tigaonline && $tiga)
                                            {{number_format(($tigaonline/$tiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
      <td>{{$tigacs = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',0)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','180')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($tigacs && $tiga)
                                            {{number_format(($tigacs/$tiga)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
      <td>{{$empat = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($empat && $allempat)
                                            {{number_format(($empat/$allempat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        <td>{{$empatonline = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',1)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($empatonline && $empat)
                                            {{number_format(($empatonline/$empat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
      <td>{{$empatcs = App\Member::orderBy('members.id','DESC')
                                        ->where('members.gym_id',$gym->id)
                                        ->where('members.registerfrom',0)
                                        ->join('package_prices','package_prices.id','=','members.package_id')
                                        ->join('member_histories','member_histories.member_id','members.id')
                                        ->whereBetween('members.expired_at',[$backdate,$currentdate])
                                        ->where('package_prices.day','365')
                                        ->get()->count()}}<div class="persen" style="visibility: hidden;"> @if($empatcs && $empat)
                                            {{number_format(($empatcs/$empat)*100,0,',','')}}%
                                            @else
                                            0%
                                            @endif    
                                         </div></td>
        
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
      value: 67,
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
                'rgba(255, 99, 132, 0.2)'
                
            ],
            borderColor: [
                'rgba(255,99,132,1)'
               
            ],
            borderWidth: 1,
            data: [45],
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