@extends('layouts.app')

@section('content')
  <x-minitutor-wrapper :minitutor="$minitutor">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Judul</th>
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
            <td class="font-weight-bold align-middle">{{ $video->category ? $video->category->name : '-' }}</td>
            <td class="font-weight-bold align-middle">{{ $video->posted_at }}</td>
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
  </x-minitutor-wrapper>
@endsection
