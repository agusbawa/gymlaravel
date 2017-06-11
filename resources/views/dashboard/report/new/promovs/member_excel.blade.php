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
		<th>Member yang Bergabung</th>
		<th>Non Promo</th>
		<th colspan="3">Promo</th>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th></th>
		<th>Jumlah</th>
		<th>Member Baru</th>
		<th>Member Perpanjangan</th>
	</tr>
	<?php $no=1; ?>	
            @foreach($title_gym as $title_gyms)
            
            @foreach($promo as $promos)
            <?php
            $jum_trans = 0;
            $tot_jum_trans = 0;
            $pers_non = 0;
            $pers_jum = 0;
            $pers_new = 0;
            $pers_ext = 0;
            $tot_trans = 0;
            $tot_non = 0;
            $tot_new = 0;
            $tot_ext = 0;
       
            $trans = 0;
            $non_promo = 0;
            $trans_new = 0;
            $trans_ext = 0;
            $non_trans = 0;
            $id_gym = DB::table('zonas')->where('id',$title_gyms)->value('id');
            $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
            $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                foreach($gym_ku as $gym_id){
                    $hit_trans = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->count();
                    $hit_non_promo = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id','0')
                            ->count();
                    $hit_trans_new = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Active')
                            ->count();
                    $hit_trans_ext = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Pending')
                            ->count();

                    $id_nonpromo = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('promo_id','0')
                                ->value('package_price_id');
                    $id_trans = DB::table('transactions')
                                ->where('gym_id',$gym_id)
                                ->where('promo_id',$promos)
                                ->value('package_price_id');
                    $id_new = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Active')
                            ->value('package_price_id');
                    $id_ext = DB::table('transactions')
                            ->where('gym_id',$gym_id)
                            ->where('promo_id',$promos)
                            ->where('status','Pending')
                            ->value('package_price_id');

                    $total_nonpromo = DB::table('package_prices')
                                ->where('package_id',$id_nonpromo)
                                ->value('price');
                    $total_trans = DB::table('package_prices')
                                ->where('package_id',$id_trans)
                                ->value('price');
                    $total_new = DB::table('package_prices')
                                ->where('package_id',$id_new)
                                ->value('price');
                    $total_ext = DB::table('package_prices')
                                ->where('package_id',$id_ext)
                                ->value('price');  

                    $trans = $hit_trans+$hit_trans;  
                    $non_promo = $non_promo+$hit_non_promo;   
                    $trans_new = $trans_new+$hit_trans_new;
                    $trans_ext = $trans_ext+$hit_trans_ext;

                    $tot_non = $tot_trans + $total_nonpromo;
                    $tot_trans = $tot_trans + $total_trans;
                    $tot_new = $tot_new + $total_new;
                    $tot_ext = $tot_ext + $total_ext;
                }
                $jum_trans = $trans + $non_trans;
                $tot_jum_trans = $tot_trans + $tot_non;
                $pers_non = round((($trans+$non_trans))*100,2);
                $pers_jum = round((($trans+$trans))*100,2);
                $pers_new = round((($trans+$trans_new))*100,2);
                $pers_ext = round((($trans+$trans_ext))*100,2);
            ?>

                  @endforeach 
            @endforeach 
	<tr>
		<th>Semua</th>
		<th>{{$jum_trans}}</th>
		<th>{{$non_promo}}</th>
		<th>{{$trans}}</th>
		<th>{{$trans_new}}</th>
		<th>{{$trans_ext}}</th>
	</tr>
</table>
</body>
</html>