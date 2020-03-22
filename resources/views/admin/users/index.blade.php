@extends('admin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Users</h3>
  </div>
  <div class="panel-body">
    <div class="row mb-15">
      <div class="col-lg-8">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Buat User</a>
      </div>
      <div class="col-lg-4">
        <form method="get" class="row">
          <div class="col-9 pr-0">
            <input type="text" name="search" placeholder="Cari user..." class="form-control" value="{{request()->input('search')}}">
          </div>
          <div class="col-3">
            <button class="btn btn-primary btn-block">Cari</button>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-bordered" id="users-table">
      <thead>
        <tr>
          <th>Id</th>
          <th>Nama</th>
          <th>Nama Pengguna</th>
          <th>Alamat Email</th>
          <th>Dibuat Pada</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
        <tr>
          <td>{{ $user->id }}</td>
          <td>{{ $user->name() }}</td>
          <td>{{ $user->username }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->created_at }}</td>
          <td class="text-center">
            <a href="{{ route('admin.users.show', $user->id) }}">Lihat</a>
            @role('Super Admin')
              @if(!$user->hasRole(['Super Admin']))
                / 
                <a href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
              @endif
            @else
              @if(!$user->hasRole(['Super Admin', 'Administrator']))
              / 
              <a href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
              @endif
            @endrole
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $users->links() }}
  </div>
</div>

@endsection