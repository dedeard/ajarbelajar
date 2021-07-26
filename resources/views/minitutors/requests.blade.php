@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Permintaan jadi MiniTutor</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('minitutors.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <table class="table table-hover m-0">
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
          @foreach ($requests as $data)
            <tr>
              <td class="align-middle">
                <span class="avatar">
                  <img width="30px" src="{{ $data->user->avatar_url }}" />
                </span>
              </td>
              <td class="align-middle"><a href="{{ route('users.show', $data->user->id) }}">{{ $data->user->name }}</a></td>
              <td class="align-middle">{{ $data->user->username }}</td>
              <td class="align-middle">{{ $data->user->email }}</td>
              <td class="text-center p-0 align-middle">
                <a href="{{ route('minitutors.request.show', $data->id) }}" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer">
        {{ $requests->links() }}
      </div>
    </div>
  </div>
@endsection
