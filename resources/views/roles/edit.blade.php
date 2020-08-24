@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Edit Role</h3>
        <div class="panel-actions">
          <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="panel-body">
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
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($permissions as $permission)
          <tr>
            <td>{{ $permission->name }}</td>
            <td class="text-center py-0 align-middle">
              <a href="{{ route('roles.toggle.sync.permission', [$role->id, $permission->id]) }}" class="btn btn-sm btn-outline-default">
                @if($role->hasPermissionTo($permission->name))
                Cabut Permission
                @else
                Beri Permission
                @endif
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
