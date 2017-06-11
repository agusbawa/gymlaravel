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
		<th>Paket yang sama</th>
		<th>Upgrade</th>
        <th>Downgrade</th>
	</tr>
	@foreach($title_gym as $title_gyms)    
            <?php 

                    $report_extends = 0;
                    $sama=0;
                    $upgrade=0;
                    $downgrade=0;
                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $nama_zona = DB::table('zonas')->where('id',$title_gyms)->value('title');
                    foreach($gym_ku as $gym_id){
                        $hit_report_extends = DB::table('member_histories')
                                            ->where('gym_id',$gym_id)
                                            ->count();
                        $long_ext_1 = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->orderBy('extends', 'desc')
                                    ->get();
                        $long_ext_2 = DB::table('member_histories')
                                    ->where('gym_id',$gym_id)
                                    ->orderBy('extends', 'desc')
                                    ->get();
                        $report_extends = $report_extends + $hit_report_extends;
                        foreach ($long_ext_1 as $long_exts_1) {
                            foreach ($long_ext_2 as $long_exts_2) {
                                if($long_exts_1->package_price_id==$long_exts_2->package_price_id){
                                    $sama++;
                                }else{
                                    if($long_exts_1->package_price_id>$long_exts_2->package_price_id){
                                        $upgrade++;
                                    }else{
                                        $downgrade++;
                                    }
                                }
                            }
                        }
                    }

            ?>
                    @endforeach 
	<tr>
		<th>Semua</th>
		<th>{{$report_extends}}</th>
		<th>{{$sama}}</th>
		<th>{{$upgrade}}</th>
        <th>{{$downgrade}}</th>
	</tr>
</table>
</body>
</html>