@extends('auth.layouts.auth')
@section('title', 'Daftar')
@section('heading', 'Buat akun baru')
@section('content')
<form method="POST" action="{{ route('register') }}" class="row mt-4">
    @csrf

    <div class="col-6">
        <div class="form-group">
            <input placeholder="Nama depan" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" />
            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <input placeholder="Nama Belakang" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" />
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <input placeholder="Nama Pengguna" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" />
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <input placeholder="Alamat Email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>



    <div class="col-6">
        <div class="form-group">
            <input placeholder="Kata Sandi" name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <input placeholder="Konfirmasi Kata Sandi" name="password_confirmation" type="password" class="form-control" />
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block btn--float font-weight-bold">DAFTAR</button>
        </div>
    </div>
</form>
@endsection