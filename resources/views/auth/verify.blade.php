@extends('auth.layouts.auth')
@section('title', 'Verifikasi Alamat Email')
@section('heading', 'Verifikasi Alamat Email Anda')

@section('content')
@if (session('resent'))
<div class="alert alert-success font-weight-bold text-center">
    {{ __('A fresh verification link has been sent to your email address.') }}
</div>
@endif
<form method="POST" action="{{ route('verification.resend') }}" class="row">
    @csrf
    <div class="col-12 mb-3">
        <p class="lead text-center">Sebelum melanjutkan, silahkan periksa Email Anda untuk tautan verifikasi. Jika Anda tidak menerima Email.</p>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <button class="btn btn-primary btn-block btn--float font-weight-bold">KLIK DISINI UNTUK MEMINTA LAGI</button>
        </div>
    </div>
</form>
@endsection
