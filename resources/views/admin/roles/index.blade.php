@extends('admin.layouts.app')
@section('title', 'Role')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Role</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tr>
        <th>Id</th>
        <th>Nama</th>
        <th class="text-center">Aksi</th>
      </tr>
      @foreach($roles as $role)
        <tr>
          <td>{{ $role->id }}</td>
          <td>{{ $role->name }}</td>
          <td class="text-center"><a href="{{ route('admin.roles.edit', $role->id) }}">Edit</a></td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
