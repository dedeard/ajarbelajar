@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Daftar Video Permintaan</h3>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th>Dikirim pada</th>
            <th>Dibuat pada</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($videos as $video)
            <tr>
              <td class="align-middle">{{ $video->title }}</td>
              <td class="align-middle">{{ $video->minitutor->user->name }}</td>
              <td class="align-middle">{{ $video->category ? $video->category->name : '-' }}</td>
              <td class="align-middle">{{ $video->requested_at }}</td>
              <td class="align-middle">{{ $video->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('request-videos.show', $video->id) }}" class="btn btn-default btn-sm" title="lihat">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer">
        {{ $videos->links() }}
      </div>
    </div>
  </div>
@endsection
