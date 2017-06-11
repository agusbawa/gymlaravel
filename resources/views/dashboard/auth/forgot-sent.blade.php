@extends('dashboard.auth.layouts')

@section('title', config('app.name').' - Password Terkirim')

@section('content')
    <h3 class="text-center">Reset Password Terkirim</h3>
    <p class="text-center">Email reset password Anda telah terkirim, silahkan cek email Anda.</p>
    <div class="text-center">
        <a href="/auth/login" class="btn btn-pink">Kembali ke halaman login</a>
    </div>
    <div class="text-center">
        <img src="/assets/images/powered-by.png" alt="Powered By">
    </div>
@endsection