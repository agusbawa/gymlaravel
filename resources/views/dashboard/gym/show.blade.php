@extends('dashboard._layout.dashboard')

@section('title', 'Gym '.$gym->title)
@section('page-title', 'Gym '.$gym->title)
@section('page-breadcrumb')
    {!!Breadcrumbs::render('gym-show',$gym)!!}
@endsection
@section('content')

<div class="m-b-15"></div>
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="widget-bg-color-icon card-box fadeInDown animated">
            <div class="bg-icon bg-icon-pink pull-left">
                <i class="md md-people text-pink"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b >{{$totalRegister}}</b></h3>
                <p class="text-muted">Total Member</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6">
        <div class="widget-bg-color-icon card-box">
            <div class="bg-icon bg-icon-info pull-left">
                <i class="md md-event text-info"></i>
            </div>
            <div class="text-right">
                <h3 class="text-dark"><b >{{$monthlyRegister}}</b></h3>
                <p class="text-muted">Member Bulan {{date('M Y')}}</p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<div class="portlet">
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark">
            Peningkatan Member / Bulan : Tahun {{date("Y")}}
        </h3>
        <div class="clearfix"></div>
    </div>
    <div class="portlet-body">
        <div class="member-growth" style="height:300px;"></div>
    </div>
</div>    

<script>window.memberGrowth = {!!$gym->memberGrowth()!!}</script>
@endsection