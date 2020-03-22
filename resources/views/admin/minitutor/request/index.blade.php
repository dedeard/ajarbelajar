@extends('admin.layouts.app')

@section('title', 'Daftar permintaan Minitutor')

@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Permintaan MiniTutor</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Nama pengguna</th>
          <th>Alamat Email</th>
          <th>Di Update</th>
          <th>Di Buat</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($requestMinitutor as $req)
        <tr>
          <td>{{ $req->id }}</td>
          <td>{{ $req->user->name() }}</td>
          <td>{{ $req->user->username }}</td>
          <td>{{ $req->user->email }}</td>
          <td>{{ $req->updated_at->format('Y/m/d') }}</td>
          <td>{{ $req->created_at->format('Y/m/d') }}</td>
          <td class="text-center">
            <a href="{{ route('admin.minitutor.request.show', $req->id) }}">Lihat</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $requestMinitutor->links() }}
  </div>
</div>

@endsection