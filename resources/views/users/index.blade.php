@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>User</h3>
        <div class="ml-auto my-auto">
          <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Buat User</a>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <form method="get" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search" aria-hidden="true"></i></button>
            </span>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Avatar</th>
              <th>Nama</th>
              <th>Poin</th>
              <th>Username</th>
              <th>Email</th>
              <th class="text-center" style="width: 140px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="align-middle">
                  <span class="avatar">
                    <img width="30px" src="{{ $user->avatar_url }}" />
                  </span>
                </td>
                <td class="align-middle"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
                <td class="align-middle">{{ $user->points }}</td>
                <td class="align-middle">{{ $user->username }}</td>
                <td class="align-middle">{{ $user->email }}</td>
                <td class="text-center py-0 align-middle">
                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-default btn-sm"><i class="fas fa-edit"></i></a>
                  <button class="btn btn-danger btn-sm btn-icon" v-delete-confirm:form-delete-user-{{ $user->id }}>
                    <i class="fas fa-trash"></i>
                  </button>
                  <form action="{{ route('users.destroy', $user->id) }}" method="post" id="form-delete-user-{{ $user->id }}">
                    @csrf
                    @method('delete')
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $users->links() }}
      </div>
    </div>
  </div>
@endsection
