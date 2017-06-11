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
		<th>Perpanjangan</th>
		<th>Paket 1 Bulan</th>
		<th>Paket 3 Bulan</th>
		<th>Paket 6 Bulan</th>
		<th>Paket 12 Bulan</th>
	</tr>
	<tr>
		<th>Semua</th>
		<th>{{App\Member::orderBy('members.id','DESC')
                                     ->join('member_histories','member_histories.member_id','=','members.id')
                                     ->get()->count()}}</th>
		<th>{{App\Member::orderBy('members.id','DESC')
                                         ->join('member_histories','member_histories.member_id','=','members.id')
                                         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                         ->where('package_prices.day','=','30')
                                         ->get()->count()}}</th>
		<th>{{App\Member::orderBy('members.id','DESC')
                                         ->join('member_histories','member_histories.member_id','=','members.id')
                                         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                         ->where('package_prices.day','=','90')
                                         ->get()->count()}}</th>
		<th>{{App\Member::orderBy('members.id','DESC')
                                         ->join('member_histories','member_histories.member_id','=','members.id')
                                         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                         ->where('package_prices.day','=','180')
                                         ->get()->count()}}</th>
		<th>{{App\Member::orderBy('members.id','DESC')
                                         ->join('member_histories','member_histories.member_id','=','members.id')
                                         ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                         ->where('package_prices.day','=','365')
                                         ->get()->count()}}</th>
	</tr>
</table>
</body>
</html>