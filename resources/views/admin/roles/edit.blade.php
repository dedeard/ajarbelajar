@extends('admin.layouts.app')
@section('title', $role->name)
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Edit Role <strong>{{ $role->name }}</strong></h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tr>
        <th>Id</th>
        <th>Permission</th>
        <th class="text-center">Aksi</th>
      </tr>
      @foreach($permissions as $permission)
        <tr>
          <td>{{ $permission->id }}</td>
          <td>{{ $permission->name }}</td>
          <td class="text-center">
            @if($role->hasPermissionTo($permission->name))
            <a href="{{ route('admin.roles.update', [$role->id, $permission->id, 'revoke']) }}">revoke</a>
            @else
            <a href="{{ route('admin.roles.update', [$role->id, $permission->id, 'sync']) }}">sync</a>
            @endif
          </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
