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
		<th>Baru</th>
		<th>Januari</th>
		<th>Februari</th>
		<th>Maret</th>
		<th>April</th>
        <th>Mei</th>
        <th>Juni</th>
        <th>Juli</th>
        <th>Agustus</th>
        <th>September</th>
        <th>Oktober</th>
        <th>November</th>
        <th>Desember</th>
	</tr>
    @foreach($title_gym as $title_gyms)

                <?php 
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
                                            ->where('new_register','like',$tahun_gym.'%')
                                            ->count();
                            $hit_jan = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-01%')
                                            ->count();
                            $hit_feb = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-02%')
                                            ->count();
                            $hit_mar = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-03%')
                                            ->count();
                            $hit_apr = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-04%')
                                            ->count();
                            $hit_mei = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-05%')
                                            ->count();
                            $hit_jun = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-06%')
                                            ->count();
                            $hit_jul = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-07%')
                                            ->count();
                            $hit_agu = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-08%')
                                            ->count();
                            $hit_sep = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-09%')
                                            ->count();
                            $hit_oct = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-10%')
                                            ->count();
                            $hit_nov = DB::table('member_histories')
                                            ->where('new_register','like',$tahun_gym.'-11%')
                                            ->count();
                            $hit_des = DB::table('member_histories')
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
                ?>

                @endforeach
	<tr>
		<th>Semua</th> 
		<th>{{$new}}</th>
		<th>{{$jan}}</th>
		<th>{{$feb}}</th>
		<th>{{$mar}}</th>
		<th>{{$apr}}</th>
        <th>{{$mei}}</th>
        <th>{{$jun}}</th>
        <th>{{$jul}}</th>
        <th>{{$agu}}</th>
        <th>{{$sep}}</th>
        <th>{{$oct}}</th>
        <th>{{$nov}}</th>
        <th>{{$des}}</th>
	</tr>
</table>
</body>
</html>