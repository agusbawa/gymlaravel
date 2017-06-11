@extends('dashboard._layout.dashboard')

@section('title', 'Edit Member')
@section('page-title', 'Edit Member')
@section('page-breadcrumb')
{!!Breadcrumbs::render('member-edit', $member)!!}
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <form action="/u/members/{{$member->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{old('name', $member->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>

                    <div class="checkbox">
                        <input name="slugcheck"  data-toggle="collapse" data-target="#slug" value="1" id="checkbox0" type="checkbox" @if((old('slugcheck',$member->slug))) checked @endif>
                        <label for="checkbox0">
                            Member Lama
                        </label>
                    </div>

                    <div id="slug" class="collapse @if((old('slugcheck', $member->slug))) in @endif">
                        <div class="form-group label-floating @if($errors->has('slug')) has-error @endif">
                            <label class="control-label">ID Member Lama</label>
                            <input type="text" class="form-control" name="slug" value="{{old('slug', $member->slug)}}">
                            @if($errors->has('slug')) <p class="help-block">{{ $errors->first('slug') }}</p> @endif
                        </div>  
                    </div>


                    <div class="form-group label-floating @if($errors->has('nick_name')) has-error @endif">
                        <label class="control-label">Nama Panggilan</label>
                        <input type="text" class="form-control" name="nick_name" value="{{old('nick_name', $member->nick_name)}}">
                        @if($errors->has('nick_name')) <p class="help-block">{{ $errors->first('nick_name') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('gender')) has-error @endif">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="clearfix"></div>
                        <div class="radio radio-pink radio-inline">
                            <input type="radio" name="gender" id="female" value="FEMALE" @if(old('gender', $member->gender)=="FEMALE" || old('gender')=="") checked @endif>
                            <label for="female">
                                Perempuan
                            </label>
                        </div>

                        <div class="radio radio-primary radio-inline">
                            <input type="radio" name="gender" id="male" value="MALE"  @if(old('gender',$member->gender)=="MALE") checked @endif>
                            <label for="male">
                                Laki Laki
                            </label>
                        </div>
                        @if($errors->has('gender')) <p class="help-block">{{ $errors->first('gender') }}</p> @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating @if($errors->has('place_of_birth')) has-error @endif">
                                <label class="control-label">Tanggal Lahir</label>
                                <input type="text" class="form-control" placeholder="Tempat Lahir" name="place_of_birth" value="{{old('place_of_birth', $member->place_of_birth)}}">
                                @if($errors->has('place_of_birth')) <p class="help-block">{{ $errors->first('place_of_birth') }}</p> @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group label-floating @if($errors->has('date_of_birth')) has-error @endif">
                                <label class="control-label">&nbsp;</label>
                                <input type="text" class="form-control datepicker" placeholder="Tanggal Lahir (tanggal/bulan/tahun)" name="date_of_birth" value="{{old('date_of_birth',$member->date_of_birth->format('d-m-Y'))}}">
                                @if($errors->has('date_of_birth')) <p class="help-block">{{ $errors->first('date_of_birth') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('address_street') || $errors->has('address_region') || $errors->has('address_city')) has-error @endif">
                        <label class="control-label">Alamat</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Jalan" name="address_street" value="{{old('address_street', $member->address_street)}}">
                                @if($errors->has('address_street')) <p class="help-block">{{ $errors->first('address_street') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kabupaten" name="address_region" value="{{old('address_region', $member->address_region)}}">
                                @if($errors->has('address_region')) <p class="help-block">{{ $errors->first('address_region') }}</p> @endif
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Kota" name="address_city" value="{{old('address_city', $member->address_city)}}">
                                @if($errors->has('address_city')) <p class="help-block">{{ $errors->first('address_city') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('phone')) has-error @endif">
                        <label class="control-label">No Telepon</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone', $member->phone)}}">
                        @if($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email', $member->email)}}">
                        @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('password')) has-error @endif">
                        <label class="control-label">Password</label>
                        <button class="btn btn-default form-control" type="button" onclick="tampil()" id="change">Show Password</button>
                        <input type="hidden"  class="form-control" id="thisval" name="password" value="{{old('password', $password)}}">
                        @if($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                        <script type="text/javascript">
                                function tampil(){
                                   var x = document.getElementById("thisval");
                                   var y =  document.getElementById("change");
                                   if(y.innerHTML=="Show Password"  ){
                                   x.setAttribute('type','password');
                                   y.innerHTML="Hide Password";
                                   }else{
                                    x.setAttribute('type','hidden');
                                   y.innerHTML="Show Password";    
                                   }
                                }
                        </script>
                    </div>

                    <div class="form-group label-floating @if($errors->has('facebook_url') || $errors->has('twitter_url') || $errors->has('instagram_url')) has-error @endif">
                        <label class="control-label">Sosial Media</label>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="facebook_url" value="{{old('facebook_url', $member->facebook_url)}}" placeholder="Link Facebook">
                                @if($errors->has('facebook_url')) <p class="help-block">{{ $errors->first('facebook_url') }}</p> @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="twitter_url" value="{{old('twitter_url', $member->twitter_url)}}" placeholder="Link Twitter">
                                @if($errors->has('twitter_url')) <p class="help-block">{{ $errors->first('twitter_url') }}</p> @endif
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="instagram_url" value="{{old('instagram_url', $member->instagram_url)}}" placeholder="Link Instagram">
                                @if($errors->has('instagram_url')) <p class="help-block">{{ $errors->first('instagram_url') }}</p> @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group label-floating @if($errors->has('hobby')) has-error @endif">
                        <label class="control-label">Hobi</label>
                        <input type="text" class="form-control" name="hobby" value="{{old('hobby', $member->hobby)}}">
                        @if($errors->has('hobby')) <p class="help-block">{{ $errors->first('hobby') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('job')) has-error @endif">
                        <label class="control-label">Pekerjaan</label>
                        <input type="text" class="form-control" name="job" value="{{old('job', $member->job)}}">
                        @if($errors->has('job')) <p class="help-block">{{ $errors->first('job') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control select2" name="gym_id">
                            <option value="">- Gym Member Mendaftar</option>
                            @foreach($gyms as $gym)
                                <option @if(old('gym', $member->gym_id)==$gym->id) selected @endif value="{{$gym->id}}">{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                    <div class="form-group text-right">
                        <input type="hidden" name="registerfrom" value="{{old('registerfrom', $member->registerfrom)}}" />
                        <a href="/u/members" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection