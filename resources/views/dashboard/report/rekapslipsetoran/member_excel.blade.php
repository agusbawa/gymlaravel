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
		<th>Rekap Slip Setoran</th>
	</tr>
	</thead>
	<tr>
		<th>Periode = </th>
	</tr>
	<tr>
		<th>Tanggal</th>
		<th colspan="2">Jumlah Pendapatan</th>
		<th rowspan="2">Tanggal Setor</th>
		<th rowspan="2">Jumlah Setoran BSM</th>
		<th rowspan="2">Paraf</th>
	</tr>
	<tr>
		<th></th>
		<th>EDC</th>
		<th>Cash</th>
	</tr>
	<?php
    $hit_cash = 0;
    $hit_edc = 0;
    $hit_bsm = 0;
    $pen_cah = DB::table('transaksi_payments')->where('payment_method','Cash')->pluck('total_bayar');
    $pen_edc = DB::table('transaksi_payments')->where('payment_method','EDC')->pluck('total_bayar');
    $pen_bsm = DB::table('setoran_bank')->pluck('total');
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
	<tr>
		<th>-</th>
		<th>{{$hit_cash}}</th>
		<th>{{$hit_edc}}</th>
		<th>-</th>
		<th>{{$hit_bsm}}</th>
		<th></th>
	</tr>
</table>
</body>
</html>