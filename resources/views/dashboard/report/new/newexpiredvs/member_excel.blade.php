<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		table, th, td {
		    border: 1px solid black;
		}
	</style>
</head>
<body>
<table>
	<thead>
	<tr>
		<th>Member Baru</th>
	</tr>
	</thead>
	<tr>
		<th>Periode = </th>
	</tr>
	<tr>
		<th>Lokasi</th>
		<th>Expired</th>
		<th>Paket 1 Bulan</th>
		<th>Paket 3 Bulan</th>
		<th>Paket 6 Bulan</th>
		<th>Paket 12 Bulan</th>
	</tr>
	<tr>
		<th>Semua</th>
	</tr>
	@foreach($title_gym as $title_gyms)
	<?php 
                        $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                        $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                        $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                        $new = 0;
                        $new_1 = 0;
                        $packet_1 = 0;
                        $packet_1s = 0;
                        $packet_2 = 0;
                        $packet_2s = 0;
                        $packet_3 = 0;
                        $packet_3s = 0;
                        $packet_4 = 0;
                        $packet_4s = 0;
                        foreach($gym_ku as $id_gym){
                            $hit_new = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date, $end_date])
                                            ->count();
                            $hit_new_1 = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_1 = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_1s = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_2 = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_2s = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_3 = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_3s = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_4 = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_4s = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $new = $new + $hit_new;
                            $new_1 = $new_1 + $hit_new_1;
                            $packet_1 = $packet_1 + $hit_packet_1;
                            $packet_1s = $packet_1s + $hit_packet_1s;
                            $packet_2 = $packet_2 + $hit_packet_2;
                            $packet_2s = $packet_2s + $hit_packet_2s;
                            $packet_3 = $packet_3 + $hit_packet_3;
                            $packet_3s = $packet_3s + $hit_packet_3s;
                            $packet_4 = $packet_4 + $hit_packet_4;
                            $packet_4s = $packet_4s + $hit_packet_4s;
                        }
                ?>
    @endforeach
	<tr>
		<th>{{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}</th>
		<th>{{$new}}</th>
		<th>{{$packet_1}}</th>
		<th>{{$packet_2}}</th>
		<th>{{$packet_3}}</th>
		<th>{{$packet_4}}</th>
	</tr>
	<tr>
		<th>{{Carbon\Carbon::parse($start_date_1)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date_1)->format('d-m-Y')}}</th>
		<th>{{$new_1}}</th>
		<th>{{$packet_1s}}</th>
		<th>{{$packet_2s}}</th>
		<th>{{$packet_3s}}</th>
		<th>{{$packet_4s}}</th>
	</tr>
</table>
</body>
</html>