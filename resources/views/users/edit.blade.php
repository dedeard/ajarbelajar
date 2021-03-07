@extends('layouts.app')

@section('content')
@component('components.user_show', ['user' => $user])
<div class="p-3">
  <form action="{{ route('users.update', $user->id) }}" method="post" class="row" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="col-lg-2 col-md-3 mb-3">
      <avatar-chooser inline-template>
        <div class="avatar-chooser">
          <span class="avatar img-bordered bg-light">
            <img :src="url || '{{ $user->avatar_url }}'" />
          </span>
          <button class="btn btn-light btn-sm btn-floating" @click="handleClick"><i class="icon wb-image"></i></button>
          <input type="file" name="image" class="avatar-chooser-input" ref="input" @change="handleChange" />
          <p class="file-name text-truncate">@{{ name }}</p>
        </div>
      </avatar-chooser>
      @error('image')
        <div class="text-danger text-center">{{ $message }}</div>
      @enderror
    </div>
    <div class="col-lg-10 col-md-9">
      @can('manage role')
        @if(!$user->hasRole('Super Admin'))
        <div class="form-group">
          <label for="role">Role</label>
          <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
            <option value="">Bukan Admin</option>
            @foreach($roles as $role)
              @php
                if(count($user->roles)) {
                  $role_id = $user->roles[0]->id;
                } else {
                  $role_id = 0;
                }
              @endphp
              <option value="{{ $role->id }}" @if($role_id == $role->id) selected @endif>{{ $role->name }}</option>
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
        <div class="checkbox-custom checkbox-primary">
          <input type="checkbox" id="email_notification" name="email_notification" @if($user->email_notification) checked @endif>
          <label for="email_notification">Email Notifikasi</label>
        </div>
      </div>

      <div class="form-group">
        <div class="checkbox-custom checkbox-primary">
          <input type="checkbox" id="email_verified" name="email_verified" @if($user->email_verified_at) checked @endif>
          <label for="email_verified">Verifikasi Alamat Email</label>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary">Edit User</button>
      </div>
    </div>
  </form>
</div>
@endcomponent
@endsection
