@extends('auth.layouts.auth')
@section('title', 'Masuk')
@section('heading', 'Masuk ke akun anda')
@section('content')
<form method="POST" action="{{ route('login') }}" class="row mt-4">
    @csrf

    <div class="col-12">
        <div class="form-group">
            <input type="text" name="identity" class="form-control @error('identity') is-invalid @enderror @error('username') is-invalid @enderror @error('email') is-invalid @enderror" name="identity" value="{{ old('identity') }}" placeholder="Alamat Email atau Nama Pengguna">
            @if ($errors->has('identity'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('identity')}}</strong>
            </span>
            @elseif ($errors->has('username') || $errors->has('email'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('username') ?: $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <input placeholder="Kata Sandi" name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }} name="remember">
                <label for="remember">Remember me</label>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="form-group">
            <button type="submit" class="btn btn-primary font-weight-bold btn-block btn--float">MASUK</button>
            <a href="{{ route('password.request') }}" class="btn btn-block mt-2 text-primary">Lupa Kata Sandi?</a>
        </div>
    </div>
</form>
@endsection