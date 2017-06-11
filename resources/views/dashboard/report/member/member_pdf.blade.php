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
		<th>Member</th>
	</tr>
	</thead>
	<tr>
		<th>Periode = </th>
	</tr>
	<tr>
		<th rowspan="2">Nama</th>
		<th rowspan="2">All</th>
		<th rowspan="2">Aktif</th>
		<th rowspan="2">Bergabung</th>
		<th colspan="5">Member Baru</th>
		<th colspan="5">Member Perpanjangan</th>
		<th rowspan="2">Expired</th>
		<th rowspan="2">Will Expired</th>
	</tr>
	<tr>
		
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
	<tr>
		<th>Semua</th>
		<th>{{$allmember}} 0%</th>
		<th>{{$activemember}} {{$per_activemember}}%</th>
		<th>{{$joinmember}} {{$per_joinmember}}%</th>
		<th>{{$paket}} {{$paket}}%</th>
		<th>{{$paketsatu}} {{$per_paketsatu}}%</th>
		<th>{{$paketdua}} {{$per_paketdua}}%</th>
		<th>{{$paketiga}} {{$per_paketiga}}%</th>
		<th>{{$paketpat}} {{$per_paketpat}}%</th>
		<th>{{$jumperpanjang}} {{$per_jumperpanjang}}%</th>
		<th>{{$panjangsatu}} {{$per_perpanjangsatu}}%</th>
		<th>{{$panjangdua}} {{$per_perpanjangdua}}%</th>
		<th>{{$panjangtiga}} {{$per_perpanjangtiga}}%</th>
		<th>{{$panjangpat}} {{$per_perpanjangpat}}%</th>
		<th>{{$expired}} {{$expired}}%</th>
		<th>{{$will}} {{$per_will}}%</th>
	</tr>
</table>
</body>
</html>