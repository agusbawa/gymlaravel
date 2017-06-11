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
		<th colspan="5">Expired</th>
		<th colspan="5">Perpanjangan</th>
		<th colspan="5">Tidak Perpanjangan</th>
	</tr> 
    <tr>
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
        <th>Jumlah</th>
        <th>Paket 1 Bulan</th>
        <th>Paket 3 Bulan</th>
        <th>Paket 6 Bulan</th>
        <th>Paket 12 Bulan</th>
    </tr>

                @foreach($title_gym as $title_gyms)
               
                <?php 
                 

                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $gym_id = DB::table('zonas')->where('id',$title_gyms)->value('id');
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    $jumlah = 0;
                    $jumlahs = 0;
                    $packet_1 = 0;
                    $packet_1s = 0;
                    $packet_2 = 0;
                    $packet_2s = 0; 
                    $packet_3 = 0;
                    $packet_3s = 0; 
                    $packet_4 = 0;
                    $packet_4s = 0;
                    foreach($gym_ku as $id_gym){
                        
                        $hit_jumlah = DB::table('member_histories')
                                        ->count();
                        $hit_jumlahs = DB::table('member_histories')
                                        ->count();
                        $hit_packet_1 = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->count();
                        $hit_packet_1s = DB::table('member_histories')
                                        ->where('package_price_id','1')
                                        ->count();
                        $hit_packet_2 = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->count();
                        $hit_packet_2s = DB::table('member_histories')
                                        ->where('package_price_id','2')
                                        ->count();    
                        $hit_packet_3 = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->count();
                        $hit_packet_3s = DB::table('member_histories')
                                        ->where('package_price_id','3')
                                        ->count();    
                        $hit_packet_4 = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->count();
                        $hit_packet_4s = DB::table('member_histories')
                                        ->where('package_price_id','4')
                                        ->count();  
                        $jumlah = $jumlah + $hit_jumlah;
                        $jumlahs = $jumlahs + $hit_jumlahs;
                        $packet_1 = $packet_1 + $hit_packet_1;
                        $packet_1s = $packet_1s + $hit_packet_1s;
                        $packet_2 = $packet_2 + $hit_packet_2;
                        $packet_2s = $packet_2s + $hit_packet_2s; 
                        $packet_3 = $packet_3 + $hit_packet_3;
                        $packet_3s = $packet_3s + $hit_packet_3s; 
                        $packet_4 = $packet_4 + $hit_packet_4;
                        $packet_4s = $packet_4s + $hit_packet_4s;
                    }
                    $total_jum = ($jumlah+$jumlahs);
                    $tot_packet1 = ($packet_1+$packet_1s);
                    $tot_packet2 = ($packet_2+$packet_2s);
                    $tot_packet3 = ($packet_3+$packet_3s);
                    $tot_packet4 = ($packet_4+$packet_4s);

                    
     ?>     
     @endforeach 
     <tr>
        <th><?php echo date("Y-m-d"); ?> - <?php echo date("Y-m-30"); ?></th>
        <th>{{$jumlah}}</th>
        <th>{{$packet_1}}</th>
        <th>{{$packet_2}}</th>
        <th>{{$packet_3}}</th>
        <th>{{$packet_4}}</th>
        <th>{{$jumlah}}</th>
        <th>{{$packet_1}}</th>
        <th>{{$packet_2}}</th>
        <th>{{$packet_3}}</th>
        <th>{{$packet_4}}</th>
        <th>{{$jumlah}}</th>
        <th>{{$packet_1}}</th>
        <th>{{$packet_2}}</th>
        <th>{{$packet_3}}</th>
        <th>{{$packet_4}}</th>
     </tr>
     <tr>
        <th><?php echo date("Y-m-d"); ?> - <?php echo date("Y-m-30"); ?></th>
        <th>{{$jumlahs}}</th>
        <th>{{$packet_1s}}</th>
        <th>{{$packet_2s}}</th>
        <th>{{$packet_3s}}</th>
        <th>{{$packet_4s}}</th>
        <th>{{$jumlah}}</th>
        <th>{{$packet_1}}</th>
        <th>{{$packet_2}}</th>
        <th>{{$packet_3}}</th>
        <th>{{$packet_4}}</th>
        <th>{{$jumlah}}</th>
        <th>{{$packet_1}}</th>
        <th>{{$packet_2}}</th>
        <th>{{$packet_3}}</th>
        <th>{{$packet_4}}</th>
     </tr>
</table>
</body>
</html>