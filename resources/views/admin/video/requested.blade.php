@extends('admin.layouts.app')
@section('title', 'Daftar Permintaan Video')
@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Permintaan Artikel</h3>
  </div>
  <div class="panel-body">
    <table id="table-requested-video" data-height="500" data-mobile-responsive="true">
      <thead>
        <tr>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="username" data-sortable="true">Username</th>
          <th data-field="title" data-sortable="true">Slug</th>
          <th data-field="requested_at" data-sortable="true">Dibuat</th>
        </tr>
      </thead>
    </table>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Id</th>
          <th>Username</th>
          <th>Title</th>
          <th>Direquest</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($videos as $video)
        <tr>
          <td>{{ $video->id }}</td>
          <td>{{ $video->user->username }}</td>
          <td>{{ $video->title }}</td>
          <td>{{ $video->requested_at }}</td>
          <td class="text-center">
            <a href="{{ route('admin.videos.requested.show', $video->id) }}">Lihat</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection