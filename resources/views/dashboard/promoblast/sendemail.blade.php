@extends('dashboard._layout.dashboard')
@section('title', 'Email Blash')
@section('page-title', 'Kirim Email Promo')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('sendemail')!!}
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <form action="/u/kirim" method="POST">
                <div class="card-box">
                    {{ method_field('POST') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('gyms')) has-error @endif">
                        <label class="control-label">List Email</label>
                        <select name="gyms[]" id="" class="select2" multiple>
                            @foreach ($gyms as $gym)
                                <option value='{{$gym->id}}'>{{$gym->title}}</option>
                            @endforeach
                        </select>
                        
                   
                        @if($errors->has('subject')) <p class="help-block">{{ $errors->first('subject') }}</p> @endif
                        <p class="help-block text-right">
                            <a href="javascript:void(0)" class="select2-bulkaction" data-type="select" data-target=".select2">Pilih Semua</a> / <a href="javascript:void(0)" class="select2-bulkaction"  data-type="deselect" data-target=".select2">Kosongkan</a>
                        </p>
                    </div>
                    <div class="form-group label-floating @if($errors->has('subject')) has-error @endif">
                        <label class="control-label">Subject</label>
                        <input type="text" class="form-control" name="subject">
                        
                   
                        @if($errors->has('subject')) <p class="help-block">{{ $errors->first('subject') }}</p> @endif

                    </div>

                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <textarea name="description" id="" cols="30" rows="10" class="summernote">{{old('description')}}</textarea>
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>
                     <div class="form-group label-floating">
                        <label class="control-label">Catatan</label>
                      <p>Variable dibawah digunakan untuk mengganti karakter yang akan diisi untuk menginputkan data sesuai data yang dipilih</p>
                      <p>Nama Member (:nama)</p>
                      <p>Email Member (:email)</p>
                      <p>Password (:password)</p>
                      <p>Tanggal expire (:expire)</p>
                      
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="reset" class="btn btn-white btn-custom waves-effect">Batal</button>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                    

                </div>
            </form>
        </div>
    </div>
@endsection