@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Video</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('videos.minitutors') }}" class="btn btn-sm btn-primary">Buat Video</a>
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
            <th>Judul</th>
            <th>Penulis</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Dibuat pada</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($videos as $video)
            <tr>
              <td class="font-weight-bold align-middle">{{ $video->title }}</td>
              <td class="font-weight-bold align-middle">{{ $video->minitutor->user->name }}</td>
              <td class="font-weight-bold align-middle">{{ $video->category ? $video->category->name : '-' }}</td>
              <td class="font-weight-bold align-middle">{{ $video->posted_at ? 'Public' : 'Draf' }}</td>
              <td class="font-weight-bold align-middle">{{ $video->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-default btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" delete-confirm="#form-delete-video-{{ $video->id }}">
                  <i class="fas fa-trash"></i>
                </button>
                <form action="{{ route('videos.destroy', $video->id) }}" method="post" id="form-delete-video-{{ $video->id }}">
                  @csrf
                  @method('delete')
                </form>
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
