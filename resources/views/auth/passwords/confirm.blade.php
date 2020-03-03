@extends('auth.layouts.auth')
@section('title', 'konfirmasi Password')
@section('heading', 'konfirmasi Password')

@section('content')
<form method="POST" action="{{ route('password.confirm') }}" class="row">
            @csrf
            <div class="col-12 mb-3">
                <p class="lead text-center">Harap konfirmasi Password Anda sebelum melanjutkan.</p>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <input type="password" class="form-control ab-form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                    @error('password')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <div class="form-group mb-3">
                    <button class="btn btn-primary btn-block btn--float font-weight-bold">KONFIRMASI PASSWORD</button>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn btn-link btn-label btn-block font-weight-bold text-uppercase">Lupa Password?</a>
                    @endif
                </div>
            </div>

        </form>
@endsection
