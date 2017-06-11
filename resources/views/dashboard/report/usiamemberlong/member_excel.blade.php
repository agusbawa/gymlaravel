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
		<th>{{App\Member::where('created_at','>=',$backdate)->count()}}</th>
		<th>{{App\Member::where('created_at','>=',$backdate)->where('registerfrom','1')->count()}}</th>
		<th>{{App\Member::where('created_at','>=',$backdate)->where('registerfrom','0')->count()}}</th>
                <th>{{App\Member::where('member_histories.new_register','>=',$backdate)
                                        ->where('registerfrom','=','1')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                        ->where('package_prices.day','=','30')
                                        ->count()}}</th>
                <th>{{App\Member::where('member_histories.new_register','>=',$backdate)
                                        ->where('members.registerfrom','=','0')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                        ->where('package_prices.day','=','30')
                                        ->count()}}</th>
                <th>{{App\Member::where('members.created_at','>=',$backdate)
                                        ->where('registerfrom','1')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                        ->where('package_prices.day','=','90')
                                        ->count()}}</th>
                <th>{{App\Member::where('members.created_at','>=',$backdate)
                                        ->where('registerfrom','0')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                        ->where('package_prices.day','=','90')
                                        ->count()}}</th>
                <th>{{App\Member::where('members.created_at','>=',$backdate)
                                        ->where('registerfrom','1')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->join('package_prices','package_prices.id','=','member_histories.package_price_id')
                                        ->where('package_prices.day','=','180')
                                        ->count()}}</th>
	</tr>
</table>
</body>
</html>