@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Edit User</h3>
    <div class="panel-actions">
      <button delete-confirm data-target="#form-delete-user-{{$user->id}}" class="btn btn-sm btn-danger">Hapus User</button>
      <form id="form-delete-user-{{$user->id}}" action="{{ route('admin.users.destroy', [$user->id, 'redirect' => 'admin.user.index']) }}" method="POST" class="d-none">
        @csrf
        @method('delete')
      </form>
    </div>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="row">
      @csrf
      @method('put')

      <div class="col-6">
        <div class="form-group">
          <label class="mb-2">Nama Depan</label>
          <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $user->first_name }}">
          @error('first_name')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-6">
        <div class="form-group">
          <label class="mb-2">Nama Belakang</label>
          <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $user->last_name }}">
          @error('last_name')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label class="mb-2">Nama pengguna</label>
          <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}">
          @error('username')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label class="mb-2">Alamat Email</label>
          <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}">
          @error('email')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>

      <div class="col-12">
        <div class="form-group">
          <label class="mb-2">Kata sandi</label>
          <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}">
          @error('password')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>


      @can('manage role')
      <div class="col-12">
        <div class="form-group">
          <label class="mb-2">Role</label>
          <select class="form-control @error('role') is-invalid @enderror" name="role">
            @foreach($roles as $role)
            <option value="{{ $role->name }}" @if($user->roles()->exists() && $user->roles()->first()->id === $role->id) selected @endif>{{ $role->name }}</option>
            @endforeach
            <option value="" @if(!$user->roles()->exists()) selected @endif>Member</option>
          </select>
          @error('role')
            <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
          @enderror
        </div>
      </div>
      @endcan

      <div class="col-12">
        <div class="form-group mb-15">
          <div class="float-left mr-20">
            <input type="checkbox" id="email_verified" name="email_verified" data-plugin="switchery" data-size="small" data-switchery="true" @if($user->email_verified_at) checked @endif>
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