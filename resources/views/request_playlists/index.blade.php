@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Playlist Permintaan</h3>
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
            @foreach($playlists as $playlist)
            <tr>
              <td class="font-weight-bold align-middle">{{ $playlist->title }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->minitutor->user->name }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->category ? $playlist->category->name : '-' }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->videos()->count() }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->requested_at }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('request-playlists.show', $playlist->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="lihat">
                  <i class="wb-eye"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="panel-footer">
        {{ $playlists->links() }}
      </div>
    </div>
  </div>
@endsection
