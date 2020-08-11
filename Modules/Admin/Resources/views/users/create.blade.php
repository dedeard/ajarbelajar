@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">CREATE USER</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('admin.users.store') }}" method="post" class="row" enctype="multipart/form-data">
          @csrf
          <div class="col-lg-2 col-md-3 mb-3">
            <avatar-chooser inline-template>
              <div class="avatar-chooser">
                <span class="avatar img-bordered bg-light">
                  <img :src="url || '{{ asset('img/placeholder/avatar.png') }}'" />
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
            <div class="form-group">
              <label for="role">Role</label>
              <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                <option value="">None</option>
                @foreach($roles as $role)
                  <option value="{{ $role->id }}" @if(old('role') == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
              </select>
              @error('role')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            @endcan

            <div class="form-group">
              <label>First Name</label>
              <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="First Name..." value="{{ old('first_name') }}">
              @error('first_name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>

            <div class="form-group">
              <label>Last Name</label>
              <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Last Name..." value="{{ old('last_name') }}">
              @error('last_name')
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
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" id="email_verified" name="email_verified" @if(old('email_verified')) checked @endif>
                <label for="email_verified">Verifikasi Alamat Email</label>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Create User</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
