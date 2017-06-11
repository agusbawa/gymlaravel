@extends('dashboard._layout.dashboard')
@section('title', 'Report Perbandingan')
@section('page-title', 'Report Pendapatan Harian')

@section('content')
<div class="row">
    <div class="col-md-10" style="margin-bottom: 10px;">
        <form action="/u/report/incomeday" class="form-inline" method="GET">
            <div class="form-group label-floating">
            <label>Tanggal</label>
                <input type="text" class="form-control datepicker" name="range" value="{{old('range')}}" required>
            <label>Cabang</label>
                <select onchange="nilaiTransaksi()" id="valuepayment" name="nama_gym" class="select2 form-control">
                    <option value="" selected="">Pilih Lokasi</option>
                @foreach($title_gym as $title_gyms)
                    <option value="{{$title_gyms}}">{{$title_gyms}}</option>
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-default" type="submit" value="true"><span class="fa fa-search"></span> Tampilkan</button>
            </div>
            @if($nama_gym!=null)
            <a class="btn btn-sm btn-success waves-effect waves-light" role="button" href="/exportExcelincomeday"><i class="glyphicon glyphicon-download-alt"></i> Export Excel</a>
            <a class="btn btn-sm btn-danger waves-effect waves-light" role="button" href="/exportPDFincomeday"><i class="glyphicon glyphicon-download-alt"></i> Export PDF</a>
            @endif
        </form>
    </div>
</div>
<div class="panel panel-default">
    <table class="table table-bordered">
        <thead>
        @if($nama_gym==null)
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Pendapatan Harian
                        </a>
                      </h4>
                    </div>
                </div>
            </div>
        @else
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      Pendapatan Harian
                    </a>
                  </h4>
                </div>

                <?php
                    $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                    $petty_cash = DB::table('petty_cash')
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$date.'%')
                                    ->value('total');
                ?>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                        <h3 class="text-dark"><b>Saldo Awal</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($petty_cash==null){
                                                                    echo 'n/a';
                                                                }else{
                                                                    echo $petty_cash;
                                                                }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_harian = 0;
                    foreach ($mharian_id as $mharian_ids) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $package_id = DB::table('members_harian')
                                        ->where('created_at','like',$date.'%')
                                        ->where('gym_id',$gym_id)
                                        ->where('id',$mharian_ids)
                                        ->value('package_id');
                            $package_price = DB::table('package_prices')
                                            ->where('package_id',$package_id)
                                            ->value('price');
                            $jum_harian = $jum_harian + $package_price;
                    }
                ?>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_harian==null){
                                                                    echo 'n/a';
                                                                }else{
                                                                    echo $jum_harian;
                                                                }?></b></h3>
                                        <p class="text-muted">Member Harian</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_pack1 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack1 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','1')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack1 = $jum_pack1 + $total_pack1;
                    }
                ?>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_pack1==null){
                                                                    echo 'n/a';
                                                                }else{
                                                                    echo $jum_pack1;
                                                                }?></b></h3>
                                        <p class="text-muted">Paket 1 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_pack2 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack2 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','2')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack2 = $jum_pack2 + $total_pack2;
                    }
                ?>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_pack2==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_pack2;
                                                            }?></b></h3>
                                        <p class="text-muted">Paket 3 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_pack3 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack3 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','3')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack3 = $jum_pack3 + $total_pack3;
                    }
                ?>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_pack3==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_pack3;
                                                            }?></b></h3>
                                        <p class="text-muted">Paket 6 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_pack4 = 0;
                    foreach ($id_trans as $id_transaction) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_pack4 = DB::table('transactions')
                                        ->where('id',$id_transaction)
                                        ->where('package_price_id','4')
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pack4 = $jum_pack4 + $total_pack4;
                    }
                ?>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_pack4==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_pack4;
                                                            }?></b></h3>
                                        <p class="text-muted">Paket 12 Bulan</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_personal = 0;
                    foreach ($id_personal as $id_personals) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_trainer = DB::table('personal_trainer')
                                        ->where('id',$id_personal)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('fee_trainer');
                            $total_gym = DB::table('personal_trainer')
                                        ->where('id',$id_personal)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('fee_gym');
                            $jum_personal = $total_trainer + $total_gym;
                    }
                ?>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_personal==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_personal;
                                                            }?></b></h3>
                                        <p class="text-muted">Personal Trainer</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_kantin = 0;
                    foreach ($id_kantin as $id_kantins) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total_kantin = DB::table('kantin')
                                        ->where('id',$id_kantins)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_kantin = $jum_kantin + $total_kantin;
                    }
                ?>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($total_kantin==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $total_kantin;
                                                            }?></b></h3>
                                        <p class="text-muted">Pendapatan Kantin</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                    $total_pendapatan = $jum_harian+$jum_pack1+$jum_pack2+$jum_pack3
                    +$jum_pack4+$jum_personal+$total_kantin;

                    $tot_pensal = $total_pendapatan + $petty_cash;
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total Pendapatan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($total_pendapatan==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $total_pendapatan;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total Pendapatan + Saldo Awal</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($tot_pensal==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $tot_pensal;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                    foreach ($id_pengeluaran as $id_pengeluarans) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $name = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('name');
                            $total = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                ?>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class="md md-attach-money text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($total==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $total;
                                                            }?></b></h3>
                                        <p class="text-muted">{{$name}}</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php } ?>

                <?php
                $jum_pengeluaran = 0;
                    foreach ($id_pengeluaran as $id_pengeluarans) {
                            $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                            $total = DB::table('pengeluaran')
                                        ->where('id',$id_pengeluarans)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->value('total');
                            $jum_pengeluaran = $jum_pengeluaran + $total;
                    }
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total Pengeluaran</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_pengeluaran==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_pengeluaran;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                    $pen_bersih = 0;
                    $pen_bersih = $tot_pensal-$jum_pengeluaran;
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Pendapatan Bersih</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($pen_bersih==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $pen_bersih;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                    $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                    $setoran_bank = DB::table('setoran_bank')
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$date.'%')
                                    ->value('total');
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Setor ke Bank</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($setoran_bank==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $setoran_bank;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                    $saldo_akhir = $pen_bersih - $setoran_bank;
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Saldo Akhir</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($saldo_akhir==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $saldo_akhir;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                <?php
                $jum_petty_cash = 0;
                    foreach ($id_petty_cash as $id_petty_cashs) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_petty_cash = DB::table('petty_cash')
                                     ->where('gym_id',$gym_id)
                                     ->where('id',$id_petty_cashs)
                                     ->where('created_at','like',$dat.'%')
                                     ->value('total');
                        $jum_petty_cash = $jum_petty_cash + $total_petty_cash;
                    }
                ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total saldo ke bank bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_petty_cash==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_petty_cash;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
            $jum_transac = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total = DB::table('transactions')
                                    ->where('id',$id_transaction)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_transac = $jum_transac + $total;
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total pendapatan bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_transac==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_transac;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
            $jum_kantin = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_kantin = DB::table('kantin')
                                    ->where('id',$id_transaction)
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_kantin = $jum_kantin + $total_kantin;
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total pendapatan kantin bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_kantin==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_kantin;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
            $jum_gym = 0;
                foreach ($id_trans as $id_transaction) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $total_gym = DB::table('transactions')
                                    ->where('id',$id_transaction)
                                    ->where('gym_id',$gym_id)
                                    ->where('created_at','like',$dat.'%')
                                    ->value('total');
                        $jum_gym = $jum_gym + $total_gym;
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Total pendapatan gym bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($jum_gym==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $jum_gym;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_expired = DB::table('member_histories')
                                        ->where('id',$id_historis)
                                        ->where('gym_id',$gym_id)
                                        ->where('expired','like',$dat.'%')
                                        ->count();
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Jumlah member expired di bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($count_expired==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $count_expired;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $back_year = $year-0001;
                        $count_back = DB::table('member_histories')
                                    ->where('id',$id_historis)
                                    ->where('gym_id',$gym_id)
                                    ->where('expired','like',$back_year.'%')
                                    ->count();
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Jumlah member expired satu tahun ke belakang</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($count_back==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $count_back;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
                foreach ($id_histori as $id_historis) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_extends = DB::table('member_histories')
                                        ->where('id',$id_historis)
                                        ->where('gym_id',$gym_id)
                                        ->where('extends','like',$dat.'%')
                                        ->count();
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Jumlah member yang perpanjang bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($count_extends==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $count_extends;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
                foreach ($id_promo as $id_promos) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_promo = DB::table('member_histories')
                                        ->where('promo_id',$id_promos)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$date.'%')
                                        ->count();
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Jumlah member yang ikut promo</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($count_promo==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $count_promo;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

            <?php
                foreach ($id_promo as $id_promos) {
                        $gym_id = DB::table('gyms')->where('title',$nama_gym)->value('id');
                        $count_promo_run = DB::table('member_histories')
                                        ->where('promo_id',$id_promos)
                                        ->where('gym_id',$gym_id)
                                        ->where('created_at','like',$dat.'%')
                                        ->count();
                } 
            ?>

                            <div class="col-md-6 col-lg-12">
                                <div class="widget-bg-color-icon card-box">
                                    <h3 class="text-dark"><b>Jumlah total member yang ikut promo bulan berjalan</b></h3>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b><?php if($count_promo_run==null){
                                                                echo 'n/a';
                                                            }else{
                                                                echo $count_promo_run;
                                                            }?></b></h3>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
        </thead>
        <tbody>        
        </tbody>
    </table>
</div>
@endsection