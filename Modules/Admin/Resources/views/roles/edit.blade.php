@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">EDIT ROLE</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name..." value="{{ $role->name }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Role</button>
          </div>
        </form>
      </div>
      <div class="panel-body">
        <h4>Edit Role Permissions</h4>
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th class="text-center" style="width: 120px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
            <tr>
              <td class="font-weight-bold">{{ $permission->name }}</td>
              <td class="text-center">
                <a href="{{ route('admin.roles.toggle.sync.permission', [$role->id, $permission->id]) }}" class="btn btn-sm btn-outline-default">
                  @if($role->hasPermissionTo($permission->name))
                  {{_('Revoke')}}
                  @else
                  {{__('Give')}}
                  @endif
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
