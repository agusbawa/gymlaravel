@extends('dashboard._layout.dashboard')
@section('title', 'Edit Target')
@section('page-title', 'Edit Target')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('target-edit',$target)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/target" method="POST">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('value')) has-error @endif">
                        <label class="control-label">Gym</label>
                        
                              <select name="gym_id" id="" class="form-control select2">
                              <option value="" selected @if(old('gym_id')=="") selected @endif>PILIH</option>
                              @foreach($gyms as $gym)
                                    <option value="{{$gym->id}}" @if(old('gym_id',$target->gym_id)==$gym->id) selected @endif>{{$gym->title}}</option>        
                              @endforeach
                                </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                    <div class="form-group label-floating @if($errors->has('value')) has-error @endif">
                        <label class="control-label">Bulan</label>
                        
                              <select name="month" id="" class="form-control select2">
                              <option value="" selected >PILIH</option>
                                    <option @if(old('month',$target->bulan)=="Januari") selected @endif value="Januari">Januari</option> 
                                    <option @if(old('month',$target->bulan)=="Februari") selected @endif value="Februari">Februari</option>
                                    <option @if(old('month',$target->bulan)=="Maret") selected @endif value="Maret">Maret</option>
                                    <option @if(old('month',$target->bulan)=="April") selected @endif value="April">April</option>
                                    <option @if(old('month',$target->bulan)=="Mei") selected @endif value="Mei">Mei</option>
                                    <option @if(old('month',$target->bulan,$target->bulan)=="Juni") selected @endif value="Juni">Juni</option>
                                    <option @if(old('month',$target->bulan)=="Juli") selected @endif value="Juli">Juli</option>
                                    <option @if(old('month',$target->bulan)=="Agustus") selected @endif value="Agustus">Agustus</option>
                                    <option @if(old('month',$target->bulan)=="September") selected @endif value="September">September</option>
                                    <option @if(old('month',$target->bulan)=="Oktober") selected @endif value="Oktober">Oktober</option>
                                    <option @if(old('month',$target->bulan)=="November") selected @endif value="November">November</option>
                                    <option @if(old('month',$target->bulan)=="Desember") selected @endif value="Desember">Desember</option>       
                                </select>
                                
                            
                        
                        
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    </div>
                     <div class="col-lg-6">
                    <div class="form-group label-floating @if($errors->has('value')) has-error @endif">
                        <label class="control-label">Tahun</label>  
                              <select name="year" id="" class="form-control select2">
                             
                                    @for($i=2000;$i<=date('Y');$i++)
                                        <option @if($i == $target->year) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                        
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('returner') || $errors->has('returner_price') ) has-error @endif">
                        <label class="control-label">Target Returner (%)</label>
                       <input type="text" class="form-control" name="returner" value="30"> 
                        @if($errors->has('returner')) <p class="help-block">{{ $errors->first('returner') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('newmember')) has-error @endif">
                        <label class="control-label">New Member</label>
                        <input type="text" class="form-control" placeholder="Jumlah new member" name="newmember" value="{{old('newmember',$target->new_member_price)}}">
                        
                        @if($errors->has('newmember')) <p class="help-block">{{ $errors->first('newmember') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('target')) has-error @endif">
                        <label class="control-label">Target Omzet</label>
                        <input type="text" class="form-control" name="target" value="{{old('target',$target->target_omset)}}">
                        @if($errors->has('target')) <p class="help-block">{{ $errors->first('target') }}</p> @endif
                    </div>
                    
                    <div class="form-group text-right">
                        <a href="/u/target" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
