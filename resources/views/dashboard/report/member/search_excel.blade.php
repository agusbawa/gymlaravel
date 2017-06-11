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
		<th>Periode = {{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}</th>
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
	@foreach ($gyms as $gym)
	<tr>
		<th>{{$gym->title}}</th>
		<th>{{$gym->members->count()}}</th>
		<th>{{$gym->members->where('status','ACTIVE')->count()}}</th>
		<th>{{$gym->members->where('type','new_register')->count()}}</th>
		<th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->get()->count()}}</th>
		<th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','new_register')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
        ->whereBetween('member_histories.new_register',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count()}}</th>
		<th>{{App\gym::where('gyms.id',$gym->id)
                            ->join('members','members.gym_id','=','gyms.id')
                            ->join('member_histories','member_histories.member_id','=','members.id')
                            ->where('members.type','extends')
                            ->whereBetween('member_histories.extends',[$backdate,$currentdate])
                            ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','30')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','90')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','180')
        ->get()->count()}}</th>
        <th>{{App\Member::where('members.status','ACTIVE')
        ->join('member_histories','member_histories.member_id','=','members.id')
        ->where('members.type','extends')
        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
       ->whereBetween('member_histories.extends',[$backdate,$currentdate])
        ->where('package_prices.day','=','365')
        ->get()->count()}}</th>
		<th>{{$gym->members()->where('expired_at','<=',$currentdate)->get()->count()}}</th>
		<th>{{$gym->members()->whereBetween('expired_at',[$currentdate,$tofifteen])->get()->count()}}</th>
	</tr>
	@endforeach
</table>
</body>
</html>