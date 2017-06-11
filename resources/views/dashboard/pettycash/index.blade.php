@extends('dashboard._layout.dashboard')


@section('help-title', 'Petty Cash')
@section('title', 'Petty Cash')
@section('page-title', 'Petty Cash')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('pettycash')!!}
@endsection

@section('content')
<div class="row">
        
            <div class="col-md-12 text-right">
                <form action="/u/pettycash" class="form-inline" method="GET">
                   
                    
                   <div class="form-group label-floating">
                        <label class="control-label">Bulan</label>
                        
                            <select name="month" class="form-control select2">
                              <option value="" selected >PILIH</option>
                                    <option @if(old('month')=="1") selected @endif value="1">Januari</option> 
                                    <option @if(old('month')=="2") selected @endif value="2">Februari</option>
                                    <option @if(old('month')=="3") selected @endif value="3">Maret</option>
                                    <option @if(old('month')=="4") selected @endif value="4">April</option>
                                    <option @if(old('month')=="5") selected @endif value="5">Mei</option>
                                    <option @if(old('month')=="6") selected @endif value="6">Juni</option>
                                    <option @if(old('month')=="7") selected @endif value="7">Juli</option>
                                    <option @if(old('month')=="8") selected @endif value="8">Agustus</option>
                                    <option @if(old('month')=="9") selected @endif value="9">September</option>
                                    <option @if(old('month')=="10") selected @endif value="10">Oktober</option>
                                    <option @if(old('month')=="11") selected @endif value="11">November</option>
                                    <option @if(old('month')=="12") selected @endif value="12">Desember</option>       
                                </select>
                       
                    </div>
                    
                    <div class="form-group label-floating">
                        <label class="control-label">Tahun</label>
                         <select name="year" id="" class="form-control select2">
                             
                                    @for($i=2000;$i<=date('Y');$i++)
                                        <option @if($i == date('Y')) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Gym</label>
                        <select class="form-control select2" name="gym">
                            @foreach($gyms as $gym)
                                    <option value="{{$gym->id}}" @if(old('gym')=="{{$gym->id}}") checked @endif>{{$gym->title}}</option>        
                              @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-default" type="submit" value="true"> Kalkulasi uang khas</button>
                    </div>    
                </form>
            </div>
        </div>
        <div class="panel panel-default table-responsive">
            
        
<table class="table">
@if($table == null)

@else
    <thead>
        <tr>
            <th>Total</th>
            <th>Gym</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($table as $row)
        @if($row->gym == null)
            @continue
        @else
        @endif
        <tr>
            <td>Rp {{Number_format($row->total)}}</td>
            <td>{{$row->gym->title}}</td>
            <td>{{$row->tanggal_petty}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
        
@endif
    </div>
@endsection