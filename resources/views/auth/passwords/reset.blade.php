@extends('auth.layouts.auth')
@section('title', 'Atur ulang kata sandi')
@section('heading', 'Atur ulang kata sandi')

@section('content')
<form method="POST" action="{{ route('password.update') }}" class="row mt-4">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="col-12">
        <div class="form-group">
            <input type="text" name="email" class="form-control ab-form-control @error('email') is-invalid @enderror" value="{{ $email ?? old('email') }}" placeholder="Alamat Email">
            @error('email')
            <span class="invalid-feedback">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <input type="password" class="form-control ab-form-control @error('password') is-invalid @enderror" name="password" placeholder="Password Baru">
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control ab-form-control" placeholder="Konfirmasi Password Baru">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <button class="btn btn-primary btn-block btn--float font-weight-bold">ATUR ULANG PASSWORD</button>
        </div>
    </div>

</form>
@endsection