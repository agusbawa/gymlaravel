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
        <th>Expired</th>
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
                                          ->join('member_histories','member_histories.member_id','=','members.id')
                                        //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                         ->where('member_histories.new_register','!=',null)
                                          ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                          ->where('members.status','ACTIVE')->get()->count()
                                       }}</th>
        <th>{{App\Zona::where('zonas.id',$zona->id)
                                        ->join('gyms','gyms.zona_id','=','zonas.id')
                                        ->join('members','members.gym_id','=','gyms.id')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                        ->where('member_histories.new_register','!=',null)
                                        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                        //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                        ->where('package_prices.day','=','30')
                                        ->get()->count()
                                     }}</th>
        <th>{{App\Zona::where('zonas.id',$zona->id)
                                      ->join('gyms','gyms.zona_id','=','zonas.id')
                                      ->join('members','members.gym_id','=','gyms.id')
                                      ->join('member_histories','member_histories.member_id','=','members.id')
                                    ->where('member_histories.new_register','!=',null)
                                      ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                      //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                      ->where('package_prices.day','=','90')
                                      ->get()->count()
                                   }}</th>
        <th>{{App\Zona::where('zonas.id',$zona->id)
                                      ->join('gyms','gyms.zona_id','=','zonas.id')
                                      ->join('members','members.gym_id','=','gyms.id')
                                      ->join('member_histories','member_histories.member_id','=','members.id')
                                    ->where('member_histories.new_register','!=',null)
                                      ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                      //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                      ->where('package_prices.day','=','180')
                                      ->get()->count()
                                   }}</th>
        <th>{{App\Zona::where('zonas.id',$zona->id)
                                        ->join('gyms','gyms.zona_id','=','zonas.id')
                                        ->join('members','members.gym_id','=','gyms.id')
                                        ->join('member_histories','member_histories.member_id','=','members.id')
                                      ->where('member_histories.new_register','!=',null)
                                        ->join('package_prices','member_histories.package_price_id','=','package_prices.id')
                                        //->whereBetween('member_histories.new_register',[$backdate,$currentdate])
                                        ->where('package_prices.day','=','365')
                                        ->get()->count()
                                     }}</th>
    </tr>
    @endforeach
</table>
</body>
</html>