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
		<th rowspan="2">Lokasi</th>
		<th rowspan="2">Jumlah Check In</th>
		<th colspan="4">Jam</th>
		<th rowspan="2">Waktu Rata-Rata</th>
		<th rowspan="2">Rata-Rata Frekuensi Hadir</th>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th>07.30-10.00</th>
		<th>10.00-16.00</th>
		<th>16.00-19.00</th>
		<th>19.00-21.00</th>
	</tr>
	<tr>
		<th>{{App\Attendance::whereBetween('check_out',[$backdate,$currentdate])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::where('check_out','<',$currentten)
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentten,$currentsix])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentsix,$currentnine])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentnine,$currentone])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentsix,$currentnine])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentnine,$currentone])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
        <th>{{App\Attendance::whereBetween('check_out',[$currentnine,$currentone])
                ->join('members','members.id','=','attendances.member_id')
                ->join('gyms','gyms.id','=','members.gym_id')
                ->get()->count()
            }}</th>
	</tr>
</table>
</body>
</html>