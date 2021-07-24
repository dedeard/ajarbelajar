@extends('layouts.app')

@section('content')
  <x-user-wrapper :user="$user">
    <form action="{{ route('users.update', $user->id) }}" method="post" class="d-block p-3" enctype="multipart/form-data">
      @csrf
      @method('put')
      @can('manage role')
        @if (!$user->hasRole('Super Admin'))
          <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
              <option value="">Bukan Admin</option>
              @foreach ($roles as $role)
                @php
                  if (count($user->roles)) {
                      $role_id = $user->roles[0]->id;
                  } else {
                      $role_id = 0;
                  }
                @endphp
                <option value="{{ $role->id }}" @if ($role_id == $role->id) selected @endif>{{ $role->name }}</option>
              @endforeach
            </select>
            @error('role')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
        @endif
      @endcan

      <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nama ..." value="{{ $user->name }}">
        @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label>Username</label>
        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username..." value="{{ $user->username }}">
        @error('username')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email..." value="{{ $user->email }}">
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
        <label>Website</label>
        <input type="text" class="form-control @error('website') is-invalid @enderror" name="website" placeholder="Website..." value="{{ $user->website }}">
        @error('website')
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
          <input type="checkbox" class="form-check-input" id="email_notification" name="email_notification" @if ($user->email_notification) checked @endif>
          <label for="email_notification">Email Notifikasi</label>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Edit User</button>
      </div>
    </form>
  </x-user-wrapper>
@endsection
