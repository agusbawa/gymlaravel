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
	<?php
                    $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                    $petty_cash = DB::table('petty_cash')
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$date.'%')
                                    ->value('total');
                ?>
	<tr>
		<th>Saldo Awal</th>
		<th>{{$petty_cash}}</th>
	</tr>
	<tr>
		<th>Pendapatan</th>
	</tr>
	<?php
                $jum_harian = 0;
                    foreach ($mharian_id as $mharian_ids) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $package_id = DB::table('members_harian')
                                        ->where('created_at','like',$date.'%')
                                        ->where('gym_id',$gym_id)
                                        ->where('id',$mharian_ids)
                                        ->value('package_id');
                            $package_price = DB::table('package_prices')
                                            ->where('package_id',$package_id)
                                            ->value('price');
                            $jum_harian = $jum_harian + $package_price;
                    }
                ?>
	<tr>
		<th>Member Harian</th>
		<th>{{$jum_harian}}</th>
	</tr>
	<?php
                $jum_pack1 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack1 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack1 = $jum_pack1 + $total_pack1;
                    }
                ?>
	<tr>
		<th>Paket 1 Bulan</th>
		<th>{{$jum_pack1}}</th>
	</tr>
	<?php
                $jum_pack2 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack2 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack2 = $jum_pack2 + $total_pack2;
                    }
                ?>
	<tr>
		<th>Paket 3 Bulan</th>
		<th>{{$jum_pack2}}</th>
	</tr>
	<?php
                $jum_pack3 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack3 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack3 = $jum_pack3 + $total_pack3;
                    }
                ?>
	<tr>
		<th>Paket 6 Bulan</th>
		<th>{{$jum_pack3}}</th>
	</tr>
	<?php
                $jum_pack4 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack4 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack4 = $jum_pack4 + $total_pack4;
                    }
                ?>
	<tr>
		<th>Paket 12 Bulan</th>
		<th>{{$jum_pack4}}</th>
	</tr>
	<?php
                $jum_personal = 0;
                    foreach ($id_personal as $id_personals) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_trainer = DB::table('personal_trainer')
                                        ->where('id',$id_personal)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('fee_trainer');
                            $total_gym = DB::table('personal_trainer')
                                        ->where('id',$id_personal)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('fee_gym');
                            $jum_personal = $total_trainer + $total_gym;
                    }
                ?>
	<tr>
		<th>Personal Trainer</th>
		<th>{{$jum_personal}}</th>
	</tr>
	<?php
                $jum_kantin = 0;
                    foreach ($id_kantin as $id_kantins) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_kantin = DB::table('kantin')
                                        ->where('id',$id_kantins)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_kantin = $jum_kantin + $total_kantin;
                    }
                ?>
	<tr>
		<th>Pendapatan Kantin</th>
		<th>{{$jum_kantin}}</th>
	</tr>
	<?php
                    $total_pendapatan = $jum_harian+$jum_pack1+$jum_pack2+$jum_pack3
                    +$jum_pack4+$jum_personal+$total_kantin;

                    $tot_pensal = $total_pendapatan + $petty_cash;
                ?>
	<tr>
		<th>Total Pendapatan</th>
		<th>{{$total_pendapatan}}</th>
	</tr>
	<tr>
		<th>Total Pendapatan + Saldo Awal</th>
		<th>{{$tot_pensal}}</th>
	</tr>
	<tr>
		<th>Pengeluaran</th>
	</tr>
	<?php
                    foreach ($id_pengeluaran as $id_pengeluarans) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $name = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at',$date)
                                        ->value('name');
                            $total = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at',$date)
                                        ->value('total');
                ?>
	<tr>
		<th>{{$name}}</th>
		<th>{{$total}}</th>
	</tr>
	<?php } ?>
	<?php
                $jum_pengeluaran = 0;
                    foreach ($id_pengeluaran as $id_pengeluarans) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pengeluaran = $jum_pengeluaran + $total;
                    }
                ?>
	<tr>
		<th>Total Pengeluaran</th>
		<th>{{$jum_pengeluaran}}</th>
	</tr>
	<?php
                    $pen_bersih = 0;
                    $pen_bersih = $tot_pensal-$jum_pengeluaran;
                ?>
	<tr>
		<th>Pendapatan Bersih</th>
		<th>{{$pen_bersih}}</th>
	</tr>
	<?php
                    $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                    $setoran_bank = DB::table('setoran_bank')
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$date.'%')
                                    ->value('total');
                ?>
	<tr>
		<th>Setor ke Bank</th>
		<th>{{$setoran_bank}}</th>
	</tr>
	<?php
                    $saldo_akhir = $pen_bersih - $setoran_bank;
                ?>
	<tr>
		<th>Saldo Akhir</th>
		<th>{{$saldo_akhir}}</th>
	</tr>
	<?php
                $jum_petty_cash = 0;
                    foreach ($id_petty_cash as $id_petty_cashs) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_petty_cash = DB::table('petty_cash')
                                     ->where('gym_id',$gym_id)
                                     ->where('id',$id_petty_cashs)
                                     ->where('created_at','like',$dat.'%')
                                     ->value('total');
                        $jum_petty_cash = $jum_petty_cash + $total_petty_cash;
                    }
                ?>
	<tr>
		<th>Total Saldo ke Bank Berjalan</th>
		<th>{{$jum_petty_cash}}</th>
	</tr>
	<?php
            $jum_transac = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total = DB::table('transactions')
                                    ->where('id',$id_transaction)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_transac = $jum_transac + $total;
                } 
            ?>
	<tr>
		<th>Total Pendapatan Bulan Berjalan</th>
		<th>{{$jum_transac}}</th>
	</tr>
	<?php
            $jum_kantin = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_kantin = DB::table('kantin')
                                    ->where('id',$id_transaction)
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_kantin = $jum_kantin + $total_kantin;
                } 
            ?>
	<tr>
		<th>Total Pendapatan Kantin Bulan Berjalan</th>
		<th>{{$jum_kantin}}</th>
	</tr>
	<?php
            $jum_gym = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_gym = DB::table('transactions')
                                    ->where('id',$id_transaction)
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_gym = $jum_gym + $total_gym;
                } 
            ?>
	<tr>
		<th>Total Pendapatan Gym Bulan Berjalan</th>
		<th>{{$jum_gym}}</th>
	</tr>
	<?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_expired = DB::table('member_histories')
                                        ->where('id',$id_historis)
                                        ->where('gym_id',$gym_id)
                                        ->where('expired','like',$dat.'%')
                                        ->count();
                } 
            ?>
	<tr>
		<th>Jumlah Member Expired di Bulan Berjalan</th>
		<th>{{$count_expired}}</th>
	</tr>
	<?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $back_year = $year-0001;
                        $count_back = DB::table('member_histories')
                                    ->where('id',$id_historis)
                                    ->where('gym_id',$gym_id)
                                    ->where('expired','like',$back_year.'%')
                                    ->count();
                } 
            ?>
	<tr>
		<th>Jumlah Member Expired 1 Tahun ke Belakang</th>
		<th>{{$count_back}}</th>
	</tr>
	<?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_extends = DB::table('member_histories')
                                        ->where('id',$id_historis)
                                        ->where('gym_id',$gym_id)
                                        ->where('extends','like',$dat.'%')
                                        ->count();
                } 
            ?>
	<tr>
		<th>Jumlah Member yang Perpanjang Bulan Berjalan</th>
		<th>{{$count_extends}}</th>
	</tr>
	<?php
                foreach ($id_promo as $id_promos) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_promo = DB::table('member_histories')
                                        ->where('promo_id',$id_promos)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->count();
                } 
            ?>
	<tr>
		<th>Jumlah Member yang Ikut Promo</th>
		<th>{{$count_promo}}</th>
	</tr>
	<?php
                foreach ($id_promo as $id_promos) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_promo_run = DB::table('member_histories')
                                        ->where('promo_id',$id_promos)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$dat.'%')
                                        ->count();
                } 
            ?>
	<tr>
		<th>Jumlah Total Member yang Ikut Promo Bulan Berjalan</th>
		<th>{{$count_promo_run}}</th>
	</tr>
</table>
</body>
</html>