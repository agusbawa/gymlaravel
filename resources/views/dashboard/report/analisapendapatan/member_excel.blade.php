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
		<th>Calon Pelanggan</th>
		<th>Konversi</th>
		<th>Pelanggan</th>
		<th>Jumlah Transaksi</th>
        <th>Rata-Rata Penjualan</th>
        <th>Omzet</th>
	</tr>
	<tr>
		<th>{{App\Member::whereBetween('created_at',[$backdate,$currentdate])->count()}}</th>
        <th>{{App\Member::whereBetween('created_at',[$backdate,$currentdate])->count()}}</th>
        <th>{{App\Member::whereBetween('created_at',[$backdate,$currentdate])->where('status','ACTIVE')->count()}}</th>
        <th>0</th>
        <th>0</th>
        <th>0</th>
        <th>0</th>
	</tr>
</table>
</body>
</html>