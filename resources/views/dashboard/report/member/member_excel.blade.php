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
		<th></th>
		<th></th>
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
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
		<th>Semua</th>
		<th>{{$allmember}}</th>
		<th>{{$activemember}}</th>
		<th>{{$joinmember}}</th>
		<th>{{$paket}}</th>
		<th>{{$paketsatu}}</th>
		<th>{{$paketdua}}</th>
		<th>{{$paketiga}}</th>
		<th>{{$paketpat}}</th>
		<th>{{$jumperpanjang}}</th>
		<th>{{$panjangsatu}}</th>
		<th>{{$panjangdua}}</th>
		<th>{{$panjangtiga}}</th>
		<th>{{$panjangpat}}</th>
		<th>{{$expired}}</th>
		<th>{{$will}}</th>
	</tr>
</table>
</body>
</html>