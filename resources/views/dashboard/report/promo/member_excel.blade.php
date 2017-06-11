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
	<tr>
		<th>Semua</th>
		<th>{{$totalmembers}}</th>
		<th>{{$totalnonpromos}}</th>
		<th>{{$totalpromos}}</th>
		<th>{{$totalmemberbaru}}</th>
		<th>{{$totalmemberpanjang}}</th>
	</tr>
</table>
</body>
</html>