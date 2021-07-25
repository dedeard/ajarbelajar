@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Pilih MiniTutor pembuat video</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('videos.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <form method="get" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </span>
          </form>
        </div>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Avatar</th>
            <th>Nama</th>
            <th>Username</th>
            <th>Email</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($minitutors as $minitutor)
            <tr>
              <td class="align-middle">
                <span class="avatar">
                  <img width="30px" src="{{ $minitutor->user->avatar_url }}" />
                </span>
              </td>
              <td class="align-middle"><a href="{{ route('videos.create', ['id' => $minitutor->id]) }}">{{ $minitutor->user->name }}</a></td>
              <td class="align-middle">{{ $minitutor->user->username }}</td>
              <td class="align-middle">{{ $minitutor->user->email }}</td>
              <td class="text-center p-0 align-middle">
                <a href="{{ route('videos.create', ['id' => $minitutor->id]) }}" class="btn btn-primary btn-sm">Pilih</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer">
        {{ $minitutors->links() }}
      </div>
    </div>
  </div>
@endsection
