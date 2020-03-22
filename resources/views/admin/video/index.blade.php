@extends('admin.layouts.app')
@section('title', 'Daftar Video')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Video</h3>
  </div>
  <div class="panel-body">
  <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Penulis</th>
          <th>Judul</th>
          <th>Status</th>
          <th>Dibuat</th>
          <th>Diupdate</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($videos as $video)
        <tr>
          <td>{{ $video->id }}</td>
          <td>{{ $video->user->name() }}</td>
          <td>{{ $video->title }}</td>
          <td>{{ $video->draf ? 'Draf' : 'Public' }}</td>
          <td>{{ $video->created_at->format('d/m/Y') }}</td>
          <td>{{ $video->updated_at->format('d/m/Y') }}</td>
          <td class="text-center">
            <a href="{{ route('admin.videos.edit', $video->id) }}">Edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection