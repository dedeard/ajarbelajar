@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>MiniTutor</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('minitutors.requests') }}" class="btn btn-sm btn-danger">Permintaan Jadi MiniTutor</a>
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
              <th>Status</th>
              <th>Dibuat pada</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($minitutors as $minitutor)
              <tr>
                <td class="align-middle">
                  <img width="33px" src="{{ $minitutor->user->avatar_url }}" />
                </td>
                <td class="align-middle"><a href="{{ route('minitutors.show', $minitutor->id) }}">{{ $minitutor->user->name }}</a></td>
                <td class="align-middle">{{ $minitutor->user->points }}</td>
                <td class="align-middle">{{ $minitutor->user->username }}</td>
                <td class="align-middle">{{ $minitutor->user->email }}</td>
                <td class="align-middle">{{ $minitutor->active ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td class="align-middle">{{ $minitutor->created_at->format('d-M-Y') }}</td>
                <td class="text-center p-0 align-middle">
                  <a href="{{ route('minitutors.show', $minitutor->id) }}" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $minitutors->links() }}
      </div>
    </div>
  </div>
@endsection
