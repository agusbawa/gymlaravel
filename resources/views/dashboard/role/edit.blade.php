@extends('dashboard._layout.dashboard')
@section('title', 'Edit Pengurus')
@section('page-title', 'Edit Pengurus')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('role-edit', $user)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/roles/{{$user->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    
                    <div class="form-group label-floating @if($errors->has('username')) has-error @endif">
                        <label class="control-label">Nama</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$user->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('username')) has-error @endif">
                        <label class="control-label">Username</label>
                        <input type="text" class="form-control" name="username" value="{{old('username',$user->username)}}">
                        @if($errors->has('username')) <p class="help-block">{{ $errors->first('username') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('email')) has-error @endif">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email',$user->email)}}">
                        @if($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('phone')) has-error @endif">
                        <label class="control-label">Nomor Telp</label>
                        <input type="text" class="form-control" name="phone" value="{{old('phone',$user->phone)}}">
                        @if($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('role')) has-error @endif">
                        <label class="control-label">Jabatan</label>
                        <select name="role" id="" class="form-control">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" @if($role->id == old('role', @$user->Role()->first()->id)) selected @endif>{{$role->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('role')) <p class="help-block">{{ $errors->first('role') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('role')) has-error @endif">
                        <label class="control-label">Pengurus dari Gym (Opsional)</label>
                        <select name="gyms[]" id="" class="select2" multiple>
                            @foreach($gyms as $gym)
                                <option  value="{{$gym->id}}" @foreach ($gymusers as $gymuser) @if($gymuser->gym_id == $gym->id) selected @endif @endforeach>{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym')) <p class="help-block">{{ $errors->first('gym') }}</p> @endif
                    </div>
                    <div class="form-group label-floating checkbox">
                   
                         <input type="checkbox" @if(old('tanggal',$user->tanggal) == 1) checked @endif class="" name="tanggal"><label class="control-label">Akses merubah tanggal</label>
                    </div>
                    <div class="form-group label-floating @if($errors->has('avatar')) has-error @endif">
                        	<label class="control-label">Foto</label>
                            	
                                <input name="avatar" class="form-control" type="file"  />
                                
							  @if($errors->has('avatar')) <p class="help-block">{{ $errors->first('avatar') }}</p> @endif
                    	</div>
                    <div class="form-group text-right">
                        <a href="/u/roles" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection