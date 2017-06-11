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
		<th>Pendapatan</th>
	</tr>
	</thead>
	<tr>
		<th>Periode = </th>
	</tr>
	<tr>
		<th>Lokasi</th>
		<th>Pendapatan</th>
		<th colspan="5">Baru</th>
		<th colspan="5">Perpanjangan</th>
		<th rowspan="2">Harian</th>
		<th rowspan="2">Personal Trainer</th>
		<th rowspan="2">Kantin</th>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th>Jumlah</th>
		<th>Paket 1 Bulan</th>
		<th>Paket 3 Bulan</th>
		<th>Paket 6 Bulan</th>
		<th>Paket 12 Bulan</th>
		<th>Jumlah</th>
		<th>Paket 1 Bulan</th>
		<th>Paket 3 Bulan</th>
		<th>Paket 6 Bulan</th>
		<th>Paket 12 Bulan</th>
	</tr>
	@foreach($title_gym as $title_gyms)
                
                <?php 
                $tot_trans = 0;
                $tot_trans_1 = 0;
                $tot_pack1 = 0;
                $tot_pack1s = 0;
                $tot_pack2 = 0;
                $tot_pack2s = 0;
                $tot_pack3 = 0;
                $tot_pack3s = 0;
                $tot_pack4 = 0;
                $tot_pack4s = 0;
                $gab_jum = 0; 
                $gab_trans = 0;
                $gab_trans1 = 0;
                $gab_total = 0;
                $gab_member = 0;
                $gab_package = 0;
                $gab_trainer = 0;
                $gab_per = 0;
                $gab_kantin = 0;
                $gab_tot = 0;  
                 
                    $jum_trans = 0;
                    $jum_trans1 = 0;
                    $members_count = 0;
                    $members_count1 = 0;
                    $count_trainer = 0;
                    $count_trainer1 = 0;
                    $count_kantin = 0;
                    $count_kantin1 = 0;
                    $jum_package=0;
                    $jum_package1=0;
                    $per_trainer = 0;
                    $per_trainer1 = 0;
                    $per_gym = 0;
                    $per_gym1 = 0;
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    $gym_ku = DB::table('zonas')->where('id',$title_gyms)->value('id');
                    $id_gym = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $kode_gym = DB::table('gyms')->where('zona_id',$title_gyms)->value('id');
                    foreach($id_gym as $id_gyms){
                  
                        $gym_id = DB::table('member_histories')->where('gym_id',$id_gyms)->whereNotNull('new_register')->value('gym_id');
  
                        $gym_id1 = DB::table('member_histories')->where('gym_id',$id_gyms)->whereNotNull('extends')->value('gym_id');

                        $total_trans = DB::table('transactions')
                                    ->where('gym_id',$gym_id)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->value('total');

                        $hit_jum_trans = DB::table('transactions')
                                    ->where('gym_id',$gym_id)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->count();

                        $hit_jum_trans1 = DB::table('transactions')
                                    ->where('gym_id',$gym_id1)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->count();
                    
                        $hit_members_count = DB::table('members_harian')
                                        ->where('gym_id',$id_gyms)
                                        ->whereBetween('created_at', [$start_date, $end_date])
                                        ->count();

                        $hit_count_trainer = DB::table('personal_trainer')
                                    ->where('gym_id',$id_gyms)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->count();

                        $hit_count_kantin = DB::table('kantin')
                                    ->where('gym_id',$id_gyms)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->count();

                        $members_harian = DB::table('members_harian')
                                        ->where('gym_id',$id_gyms)
                                        ->whereBetween('created_at', [$start_date, $end_date])
                                        ->pluck('package_id');       
                        
                        foreach ($members_harian as $members_harians) {
                            $package = DB::table('package_prices')->where('package_id',$members_harians)
                                        ->value('price');
                            $jum_package=$jum_package+$package;
                        }

                        $hit_per_trainer = DB::table('personal_trainer')
                                    ->where('gym_id',$id_gyms)
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->value('fee_trainer');
                        $hit_per_gym = DB::table('personal_trainer')
                                        ->where('gym_id',$id_gyms)
                                        ->whereBetween('created_at', [$start_date, $end_date])
                                        ->value('fee_gym');

                        $per_trainer = $per_trainer + $hit_per_trainer;
                        $per_gym = $per_gym + $hit_per_gym;

                        $count_kantin = $count_kantin + $hit_count_kantin;

                        $count_trainer = $count_trainer + $hit_count_trainer;

                        $members_count = $members_count + $hit_members_count;

                        $jum_trans = $jum_trans + $hit_jum_trans;
                        $jum_trans1 = $jum_trans1 + $hit_jum_trans1;

                        $tot_trans = $tot_trans + $total_trans;
                    }
                    $per_jumlah = $per_trainer+$per_gym;

                    $tot_kantin=0;
                    $jum_kantin = DB::table('kantin')
                                    ->whereBetween('created_at', [$start_date, $end_date])
                                    ->where('gym_id',$kode_gym)
                                    ->value('total');
                    $tot_kantin = $tot_kantin + $jum_kantin;

                    $jumlah = $tot_trans+$jum_package+$per_jumlah+$tot_kantin;
	                $gab_jum = $jumlah;
	                $gab_trans = $jum_trans;
	                $gab_trans1 = $jum_trans1;
	                $gab_total = $tot_trans;
	                $gab_member = $members_count;
	                $gab_package = $jum_package;
	                $gab_trainer = $count_trainer;
	                $gab_per = $per_jumlah;
	                $gab_kantin = $count_kantin;
	                $gab_tot = $tot_kantin;    
		 ?>
		 @endforeach 
	<tr>
		<th>Semua</th>
		<th>{{$gab_jum}}</th>
		<th>{{$gab_trans}}</th>
		<th>{{$tot_pack1}}</th>
		<th>{{$tot_pack2}}</th>
		<th>{{$tot_pack3}}</th>
		<th>{{$tot_pack4}}</th>
		<th>{{$gab_trans1}}</th>
		<th>{{$tot_pack1s}}</th>
		<th>{{$tot_pack2s}}</th>
		<th>{{$tot_pack3s}}</th>
		<th>{{$tot_pack4s}}</th>
		<th>{{$gab_member}}</th>
		<th>{{$gab_trainer}}</th>
		<th>{{$gab_kantin}}</th>
	</tr>
</table>
</body>
</html>