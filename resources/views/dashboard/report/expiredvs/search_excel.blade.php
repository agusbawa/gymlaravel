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
        <th>Periode = {{Carbon\Carbon::parse($backdate)->format('d-m-Y')}} - {{Carbon\Carbon::parse($currentdate)->format('d-m-Y')}}</th>
    </tr>
    <tr>
        <th>Lokasi</th>
        <th colspan="3">Expired</th>
        <th colspan="3">Paket 1 Bulan</th>
        <th colspan="3">Paket 3 Bulan</th>
        <th colspan="3">Paket 6 Bulan</th>
        <th colspan="3">Paket 12 Bulan</th>
    </tr>
    <tr>
        <th></th>
        <th>Jumlah</th>
        <th>Online</th>
        <th>CS</th>
        <th>Jumlah</th>
        <th>Online</th>
        <th>CS</th>
        <th>Jumlah</th>
        <th>Online</th>
        <th>CS</th>
        <th>Jumlah</th>
        <th>Online</th>
        <th>CS</th>
        <th>Jumlah</th>
        <th>Online</th>
        <th>CS</th>
    </tr>
    @foreach ($gyms as $gym)
    <tr>
        <th>{{$gym->title}}</th>
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
                                         ->where('package_prices.day','=','30')
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
                                         ->where('package_prices.day','=','90')
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
                                         ->where('package_prices.day','=','180')
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
    </tr>
    @endforeach
</table>
</body>
</html>