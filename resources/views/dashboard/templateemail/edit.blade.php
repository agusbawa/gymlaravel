@extends('dashboard._layout.dashboard')
@section('title', 'Edit Setoran Bank')
@section('page-title', 'Edit Setoran Bank')
@section('page-breadcrumb')
    {!!Breadcrumbs::render('edit-templateemail', $template)!!}
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form action="/u/templateemail/{{$template->id}}" method="POST">
                <div class="card-box">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group label-floating @if($errors->has('title')) has-error @endif">
                        <label class="control-label">Title</label>
                       <input type="text" name="title" class="form-control" value="{{old('description',$template->title)}}">
                        @if($errors->has('title')) <p class="help-block">{{ $errors->first('title',$template->title) }}</p> @endif
                    </div>

                    <div class="form-group label-floating @if($errors->has('description')) has-error @endif">
                        <textarea name="description" id="" cols="30" rows="10" class="summernote">{{old('description',$template->pesan)}}</textarea>
                        @if($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                    </div>
                    <div class="form-group label-floating">
                        <label class="control-label">Catatan</label>
                      <p>Variable dibawah digunakan untuk mengganti karakter yang akan diisi untuk menginputkan data sesuai data yang dipilih</p>
                      <p>Nama Member (:nama)</p>
                      <p>Email Member (:email)</p>
                      <p>Password (:password)</p>
                      <p>Tanggal expire (:expire)</p>
                      <p>Invoice Pembayaran(:invoice)(khusus Invoice Pembayaran)</p>
                      <p>Kode Booking(:book)(Khusus Kode Booking Member Baru ataupun <perpanjangan></perpanjangan>)</p>
                      
                    </div>

                    <div class="form-group text-right">
                        <a href="/u/templateemail" class="btn btn-white btn-custom waves-effect">Batal</a>
                        <button type="submit" value="1" class="btn btn-pink waves-effect waves-light">Simpan</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
@endsection