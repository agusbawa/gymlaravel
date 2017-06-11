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
		<th>Allmember</th>
		<th>> 18 Tahun</th>
		<th>18-24 Tahun</th>
        <th>25-34 Tahun</th>
        <th>35-44 Tahun</th>
        <th>45-54 Tahun</th>
        <th>55-64 Tahun</th>
        <th>65 +</th>
	</tr>
	<tr>
		<th>Semua</th>
		<th>{{App\Member::get()->count()}}</th>
		<th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-18))->get()->count()}}</th>
		<th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-18))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-24))->get()->count()}}</th>
        <th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-25))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-34))->get()->count()}}</th>
        <th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-35))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-44))->get()->count()}}</th>
        <th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-45))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-54))->get()->count()}}</th>
        <th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-55))->where('date_of_birth','>',Carbon\Carbon::now()->addYear(-64))->get()->count()}}</th>
        <th>{{App\Member::orderBy('nick_name','asc')->where('date_of_birth','<',Carbon\Carbon::now()->addYear(-65))->get()->count()}}</th>
	</tr>
</table>
</body>
</html>