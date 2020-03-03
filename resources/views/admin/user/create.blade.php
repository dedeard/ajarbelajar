@extends('admin.layouts.app')

@section('title', 'Buat Pengguna')

@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Buat pengguna</h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.user.store') }}" method="POST" class="row">
      @csrf

      <div class="col-6">
        <div class="form-group">
          <label for="first_name">Nama Depan</label>
          <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}">
          @error('first_name')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-6">
        <div class="form-group">
          <label for="last_name">Nama Belakang</label>
          <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}">
          @error('last_name')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="username">Nama pengguna</label>
          <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}">
          @error('username')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="email">Alamat Email</label>
          <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
          @error('email')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label for="password">Kata sandi</label>
          <input type="text" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}">
          @error('password')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group mb-15">
          <div class="form-group mb-15">
            <div class="float-left mr-20">
              <input type="checkbox" id="admin" name="admin" data-plugin="switchery" data-size="small" data-switchery="true" @if(old('admin')) checked @endif>
            </div>
            <label for="admin">
              Administrator
            </label>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="form-group mb-15">
          <div class="float-left mr-20">
            <input type="checkbox" id="email_verified" name="email_verified" data-plugin="switchery" data-size="small" data-switchery="true" @if(old('email_verified')) checked @endif>
          </div>
          <label for="email_verified">
            Verifikasi Alamat Email
          </label>
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
            <span class="ladda-label">Simpan</span>
          </button>
        </div>
      </div>

    </form>
  </div>
</div>
@endsection