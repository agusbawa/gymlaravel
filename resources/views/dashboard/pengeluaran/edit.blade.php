@extends('dashboard._layout.dashboard')
@section('title', 'Edit Pengeluaran')
@section('page-title', 'Edit Pengeluaran')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('pengeluaran-edit', $pengeluaran)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/pengeluaran/{{$pengeluaran->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('name')) has-error @endif">
                        <label class="control-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name',$pengeluaran->name)}}">
                        @if($errors->has('name')) <p class="help-block">{{ $errors->first('name') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('total')) has-error @endif">
                        <label class="control-label">Total</label>
                        <input type="text" class="form-control" name="total" value="{{old('total',$pengeluaran->total)}}">
                        @if($errors->has('total')) <p class="help-block">{{ $errors->first('total') }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('gym_id')) has-error @endif">
                        <label class="control-label">Gym</label>
                        <select class="form-control" id="gym_id" name="gym_id">
                            <option value="">Gym</option>
                            @foreach($gyms as $gym)
                                <option @if(old('gym',$pengeluaran->gym_id)==$gym->id) selected @endif value="{{$gym->id}}" >{{$gym->title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id')) <p class="help-block">{{ $errors->first('gym_id') }}</p> @endif
                    </div>
                      <div class="form-group label-floating @if($errors->has('tgl_keluar')) has-error @endif">
                        <label class="control-label">Tanggal Pengeluaran</label>
                        <input   @if(\App\User::where('id',Auth::user()->id)->where('tanggal','0')->count() == 1) readonly="true" class="form-control" @else  class="form-control datepicker"  @endif type="text" name="tgl_keluar" value="{{old('tgl_keluar',date('d-m-Y',strtotime($pengeluaran->tgl_keluar)))}}" >
                        @if($errors->has('tgl_keluar')) <p class="help-block">{{ $errors->first('tgl_keluar') }}</p> @endif
                    </div>
                    <div class="form-group label-floating @if($errors->has('deskripsi')) has-error @endif">
                        <label class="control-label">Deskripsi</label>
                       <textarea name="deskripsi" id="" cols="30" rows="10" class="summernote">{{old('deskripsi',$pengeluaran->deskripsi)}}</textarea>
                        @if($errors->has('deskripsi')) <p class="help-block">{{ $errors->first('deskripsi') }}</p> @endif
                    </div>
                    <div class="form-group text-right">
                        <a href="/u/pengeluaran" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection