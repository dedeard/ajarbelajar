@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Daftar Playlist Permintaan</h3>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Jumlah Video</th>
              <th>Dikirim pada</th>
              <th>Dibuat pada</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($playlists as $playlist)
              <tr>
                <td class="font-weight-bold align-middle">{{ $playlist->title }}</td>
                <td class="font-weight-bold align-middle">{{ $playlist->minitutor->user->name }}</td>
                <td class="font-weight-bold align-middle">{{ $playlist->category ? $playlist->category->name : '-' }}</td>
                <td class="font-weight-bold align-middle">{{ $playlist->videos()->count() }}</td>
                <td class="font-weight-bold align-middle">{{ $playlist->requested_at }}</td>
                <td class="font-weight-bold align-middle">{{ $playlist->created_at }}</td>
                <td class="text-center py-0 align-middle">
                  <a href="{{ route('request-playlists.show', $playlist->id) }}" class="btn btn-default btn-sm" title="lihat">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $playlists->links() }}
      </div>
    </div>
  </div>
@endsection
