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
	@foreach ($zonas as $zona)
	<tr>
		<th>{{$zona->title}}</th>
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                        ->join('gyms','gyms.zona_id','=','zonas.id')
                                        ->join('members','members.gym_id','=','gyms.id')
                                        ->get()->count()
                                     }}</th>
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->where('members.status','ACTIVE')->get()->count()
                                 }}</th>
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->join('member_histories','member_histories.member_id','=','members.id')
                                  //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                    ->where('members.status','ACTIVE')->get()->count()
                                 }}</th>
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->join('member_histories','member_histories.member_id','=','members.id')
                                  //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                   ->where('members.type','new_register')
                                    ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                    ->where('members.status','ACTIVE')->get()->count()
                                 }}</th>
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
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->join('member_histories','member_histories.member_id','=','members.id')
                                    ->where('members.type','extends')
                                    ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                    //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                   
                                    ->get()->count()
                                 }}</th>
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
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                        ->join('gyms','gyms.zona_id','=','zonas.id')
                                        ->join('members','members.gym_id','=','gyms.id')
                                        ->where('expired_at','<=',$currentdate)
                                        ->get()->count()
                                     }}</th>
		<th>{{App\Zona::where('zonas.id',$zona->id)
                                    ->join('gyms','gyms.zona_id','=','zonas.id')
                                    ->join('members','members.gym_id','=','gyms.id')
                                    ->whereBetween('expired_at',[$currentdate,$tofifteen])
                                    ->get()->count()
                                 }}</th>
	</tr>
	@endforeach
</table>
</body>
</html>