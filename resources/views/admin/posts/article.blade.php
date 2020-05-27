@extends('admin.layouts.app')
@section('title', 'Daftar Artikel Minitutor')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Artikel Minitutor</h3>
  </div>
  <div class="panel-body" style="overflow-x: auto">
  <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Judul</th>
          <th>Email</th>
          <th>Kontak</th>
          <th>Link Kontent</th>
          <th>Link Profile</th>
        </tr>
      </thead>
      <tbody>
        @foreach($posts as $post)
        <tr>
          <td>{{ $post->user->name() }}</td>
          <td>{{ $post->title }}</td>
          <td>{{ $post->user->email }}</td>
          <td>{{ $post->user->minitutor->contact }}</td>
          <td>{{ route('post.show', $post->slug) }}</td>
          <td>{{ route('minitutor.show', $post->user->username) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $posts->links() }}
  </div>
</div>
@endsection
