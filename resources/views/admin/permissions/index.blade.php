@extends('admin.layouts.app')
@section('title', 'Permissions')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Permissions</h3>
    <div class="panel-actions">
      <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">CREATE</a>
    </div>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tr>
        <th>Id</th>
        <th>Nama</th>
        <th class="text-center">Aksi</th>
      </tr>
      @foreach($permissions as $permission)
        <tr>
          <td>{{ $permission->id }}</td>
          <td>{{ $permission->name }}</td>
          <td class="text-center">
            <button delete-confirm data-target="#form-delete-permission-{{$permission->id}}" class="btn btn-sm btn-danger">Hapus</button>
            <form id="form-delete-permission-{{$permission->id}}" action="{{ route('admin.permissions.destroy', [$permission->id, 'redirect' => 'admin.user.index']) }}" method="POST" class="d-none">
              @csrf
              @method('delete')
            </form>
          </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
