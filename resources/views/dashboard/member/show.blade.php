@extends('dashboard._layout.dashboard')

@section('title', 'Member '.$member->title)
@section('page-title', 'Member '.$member->title)
@section('page-breadcrumb')
    {!!Breadcrumbs::render('member-show',$member)!!}
@endsection
@section('content')
<a href="/u/members/extend/{{$member->id}}" class="btn btn-primary btn-custom waves-effect waves-light">Perpanjang Paket</a>
<div class="m-b-15"></div>
<div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card-box">
            <a href="/u/members/{{$member->id}}/edit" class="pull-right btn btn-default btn-sm waves-effect waves-light">Edit</a>
            <h4 class="m-t-0 header-title"><b>Informasi Personal</b></h4>
            <div class="p-20">
                <div class="about-info-p">
                    <strong>Nama Lengkap</strong>
                    <br>
                    <p class="text-muted">{{$member->name}} ({{$member->nick_name}})</p>
                </div>
                <div class="about-info-p">
                    <strong>Jenis Kelamin</strong>
                    <br>
                    <p class="text-muted">{{($member->gender=="FEMALE")?"Wanita":"Pria"}}</p>
                </div>
                <div class="about-info-p">
                    <strong>No Telp</strong>
                    <br>
                    <p class="text-muted">{{$member->phone}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Email</strong>
                    <br>
                    <p class="text-muted">{{$member->email}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Hobi</strong>
                    <br>
                    <p class="text-muted">{{$member->hobby}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Pekerjaan</strong>
                    <br>
                    <p class="text-muted">{{$member->job}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Gym</strong>
                    <br>
                    <p class="text-muted">{{$member->gym->title}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Expire</strong>
                    <br>
                    <p class="text-muted">{{$member->expired_at}}</p>
                </div>
                <div class="about-info-p">
                    <strong>Status</strong>
                    <br>
                    <p class="text-muted">{{$member->status}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-8">
        <div class="card-box">
            <h4 class="m-t-0 header-title"><b>Aktifitas Gym</b></h4>
            <div class="p-20">
                <div class="timeline-2">
                    @foreach($memberAttendances as $memberAttendance)
                        @if($memberAttendance->check_in != $memberAttendance->check_out)
                            <div class="time-item">
                            <div class="item-info">
                                <div class="text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$memberAttendance->check_out->format("d M Y H:i:s")}}">{{$memberAttendance->check_out->diffForHumans()}}</div>
                                <p><strong><a href="#" class="text-info">Check Out</a></strong> pada Gym <strong>{{$memberAttendance->gym->title}}</strong></p>
                            </div>
                        </div>
                        @endif
                        <div class="time-item">
                            <div class="item-info">
                                <div class="text-muted"  data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$memberAttendance->check_in->format("d M Y H:i:s")}}">{{$memberAttendance->check_in->diffForHumans()}}</div>
                                <p><strong><a href="#" class="text-pink">Check In</a></strong> pada Gym <strong>{{$memberAttendance->gym->title}}</strong></p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="portlet">
    <div class="portlet-heading">
        <h3 class="portlet-title text-dark">
            Laporan Transaksi
        </h3>
        <div class="clearfix"></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                
                <th>Subtotal</th>
                <th>Discount</th>
                <th>Grand Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberTransactions as $transaction)
                <tr>
                    <td>{{$transaction->created_at}}</td>
                            
                    <td>Rp.{{number_format($transaction->total)}}</td>
                    
                    <td>@if($transaction->promo == null || $transaction->promo_id == '0') -- @else @if($transaction->promo->unit == "NOMINAL") Rp.{{number_format($transaction->promo->value)}} @else {{$transaction->promo->value}}% @endif @endif</td>
                    <td> Rp.{{number_format($transaction->total)}}</td>
                    <td>{{$transaction->status}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $memberTransactions->links() }}
@endsection