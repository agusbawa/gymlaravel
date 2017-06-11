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
		<th>Expired</th>
		<th>Perpanjangan</th>
		<th>Tidak Perpanjangan</th>
	</tr>
	@foreach($title_gym as $title_gyms)
                <?php 
                    $gym_ku = DB::table('gyms')->where('zona_id',$title_gyms)->pluck('id');
                    $hit_expired = 0;
                    $hit_expired_1 = 0;
                    $hit_extends = 0;
                    $hit_extends_1 = 0;
                    $hit_no = 0;
                    $hit_no_1 = 0;
                    foreach($gym_ku as $gym_id){
                            $report_expired = DB::table('member_histories')
                                            ->count();
                            $report_expired_1 = DB::table('member_histories')
                                            ->count();
                            $report_extends = DB::table('member_histories')
                                            ->count();
                            $report_extends_1 = DB::table('member_histories')
                                            ->count();

                            $long_exps = DB::table('member_histories')
                                        ->first();
                            $no=0;
                            if($long_exps==null){
                                $range_date = "0"; 
                            }else{
                                $long_date = $long_exps->expired;
                                $now  = Carbon\Carbon::parse(Carbon\Carbon::now());
                                $end  = Carbon\Carbon::parse($long_date);
                                $range_date = $end->diffInDays($now); 
                            }
                            if ($range_date>1){
                                $no++;
                            }

                            $long_exps_1 = DB::table('member_histories')
                                            ->first();
                            $no_1=0;
                            if($long_exps_1==null){
                                $range_date_1="0";
                            }else{
                                $long_date_1 = $long_exps_1->expired;
                                $now_1  = Carbon\Carbon::parse(Carbon\Carbon::now());
                                $end_1  = Carbon\Carbon::parse($long_date_1);
                                $range_date_1 = $end_1->diffInDays($now_1);
                            }
                                if ($range_date_1>1){
                                    $no_1++;
                            }
                            $hit_expired = $hit_expired+$report_expired;
                            $hit_expired_1 = $hit_expired_1+$report_expired_1;
                            $hit_extends = $hit_extends+$report_extends;
                            $hit_extends_1 = $hit_extends_1+$report_extends_1;
                            $hit_no = $hit_no + $no;
                            $hit_no_1 = $hit_no_1 + $no_1;
                    }
                    $per_expired = round((($hit_expired+$hit_expired_1)*100),2);
                    $per_extends = round((($hit_extends+$hit_extends_1)*100),2);
                    $per_no = (($hit_no+$hit_no_1))*100;

                    $jum_exp = $hit_expired+$hit_expired_1;
                    $jum_ext = $hit_extends+$hit_extends_1;
                    $jum_no = $hit_no+$hit_no_1;      
                ?>
                @endforeach 
	<tr>
		<th>Semua</th>
		<th>{{$jum_exp}}</th>
		<th>{{$jum_ext}}</th>
		<th>{{$jum_no}}</th>
	</tr>
</table>
</body>
</html>