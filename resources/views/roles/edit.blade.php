@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Edit Role</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="post">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama..." value="{{ $role->name }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Role</button>
          </div>
        </form>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Nama</th>
            <th class="text-center" style="width: 180px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
            <tr>
              <td>{{ $permission->name }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('roles.toggle.sync.permission', [$role->id, $permission->id]) }}"
                  class="btn btn-sm btn-block {{ $role->hasPermissionTo($permission->name) ? 'btn-danger' : 'btn-primary' }}">
                  {{ $role->hasPermissionTo($permission->name) ? 'Cabut Permission' : 'Beri Permission' }}
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
