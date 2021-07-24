@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Buat User</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
          @csrf

          @can('manage role')
            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                <option value="">Bukan Admin</option>
                @foreach ($roles as $role)
                  <option value="{{ $role->id }}" @if (old('role') == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
              </select>
              @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          @endcan

          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama..." value="{{ old('name') }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username..." value="{{ old('username') }}">
            @error('username')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email..." value="{{ old('email') }}">
            @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Password</label>
            <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password..." value="{{ old('password') }}">
            @error('password')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label>Avatar</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" name="image" id="custom-input-avatar" accept="image/*">
              <label class="custom-file-label @error('image') border-danger @enderror" for="custom-input-avatar">Pilih Gambar</label>
            </div>
            @error('image')
              <span class="invalid-feedback d-block">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="email_notification" name="email_notification" @if (old('email_notification')) checked @endif>
              <label for="email_notification">Email Notifikasi</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat User</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
