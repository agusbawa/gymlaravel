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
        <th>Periode = {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}</th>
    </tr>
    <tr>
        <th>Lokasi</th>
        <th>Perpanjangan</th>
        <th>Paket 1 Bulan</th>
        <th>Paket 3 Bulan</th>
        <th>Paket 6 Bulan</th>
        <th>Paket 12 Bulan</th>
    </tr>
    @foreach($title_gym as $title_gyms)
                <?php 
                    if($nama_gym==1||$nama_gym==3||$nama_gym==5||$id!=null){
                        $gym_id = DB::table('gyms')->where('title',$title_gyms)->value('id');
                        $hit_new = DB::table('member_histories')
                                        ->where('gym_id',$gym_id)
                                        ->whereNotNull('new_register')
                                        ->whereBetween('expired', [$start_date, $end_date])
                                        ->count();
                        $hit_new_1 = DB::table('member_histories')
                                        ->where('gym_id',$gym_id)
                                        ->whereNotNull('new_register')
                                        ->whereBetween('expired', [$start_date_1, $end_date_1])
                                        ->count();
                        $hit_packet_1 = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $hit_packet_1s = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $hit_packet_2 = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $hit_packet_2s = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $hit_packet_3 = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $hit_packet_3s = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                        $hit_packet_4 = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date, $end_date])
                                        ->count();
                        $hit_packet_4s = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->whereBetween('extends', [$start_date_1, $end_date_1])
                                        ->count();
                    }else if($nama_gym==2||$nama_gym==4){
                        $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                        $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                        $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                        $new = 0;
                        $new_1 = 0;
                        $packet_1 = 0;
                        $packet_1s = 0;
                        $packet_2 = 0;
                        $packet_2s = 0;
                        $packet_3 = 0;
                        $packet_3s = 0;
                        $packet_4 = 0;
                        $packet_4s = 0;
                        foreach($gym_ku as $id_gym){
                            $hit_new = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date, $end_date])
                                            ->count();
                            $hit_new_1 = DB::table('member_histories')
                                            ->where('gym_id',$id_gym)
                                            ->whereNotNull('new_register')
                                            ->whereBetween('expired', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_1 = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_1s = DB::table('member_histories')
                                            ->where('package_price_id','1')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_2 = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_2s = DB::table('member_histories')
                                            ->where('package_price_id','2')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_3 = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_3s = DB::table('member_histories')
                                            ->where('package_price_id','3')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                            $hit_packet_4 = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date, $end_date])
                                            ->count();
                            $hit_packet_4s = DB::table('member_histories')
                                            ->where('package_price_id','4')
                                            ->where('gym_id',$id_gym)
                                            ->whereBetween('extends', [$start_date_1, $end_date_1])
                                            ->count();
                        }
                    }
                ?>
    <tr>
        @if($nama_gym==2||$nama_gym==4)
            <th>{{$nama_zona}}</th>
        @elseif($nama_gym==1||$nama_gym==3||$nama_gym==5||$id!=null)
            <th>{{$title_gyms}}</th>
        @endif
    </tr>
    <tr>
        <th>{{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}</th>
        <th>{{$hit_new}}</th>
        <th>{{$hit_packet_1}}</th>
        <th>{{$hit_packet_2}}</th>
        <th>{{$hit_packet_3}}</th>
        <th>{{$hit_packet_4}}</th>
    </tr>
    <tr>
        <th>{{Carbon\Carbon::parse($start_date_1)->format('d-m-Y')}} - {{Carbon\Carbon::parse($end_date_1)->format('d-m-Y')}}</th>
        <th>{{$hit_new_1}}</th>
        <th>{{$hit_packet_1s}}</th>
        <th>{{$hit_packet_2s}}</th>
        <th>{{$hit_packet_3s}}</th>
        <th>{{$hit_packet_4s}}</th>
    </tr>
    @endforeach 
</table>
</body>
</html>