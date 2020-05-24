@extends('admin.layouts.app')
@section('title', 'Daftar Konten Minitutor')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Konten Minitutor</h3>
  </div>
  <div class="panel-body">
  <table class="table table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Judul</th>
          <th>Email</th>
          <th>Kontak</th>
        </tr>
      </thead>
      <tbody>
        @foreach($posts as $post)
        <tr>
          <td>{{ $post->user->name() }}</td>
          <td>{{ $post->title }}</td>
          <td>{{ $post->user->email }}</td>
          <td>{{ $post->user->minitutor->contact }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $posts->links() }}
  </div>
</div>
@endsection
