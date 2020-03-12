@extends('admin.layouts.app')
@section('title', 'Komentar')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Komentar</h3>
  </div>
  <div class="panel-body">
    <table class="table">
      <tr>
        <th>Judul</th>
        <th>Tipe</th>
        <th>Nama</th>
        <th>Bodi</th>
        <th>Aksi</th>
      </tr>
      @foreach($comments as $comment)
        <tr>
          <td>{{ $comment->post->title }}</td>
          <td>{{ ($comment->post->type == 'article') ? 'Artikel' : 'Vidio' }}</td>
          <td>{{ $comment->user->name() }}</td>
          <td>{{ $comment->body }}</td>
          <td><a href="{{ route('admin.comment.approve.toggle', $comment->id) }}">{{ $comment->approved ? 'Tarik' : 'Publikasikan' }}</a></td>
        </tr>
      @endforeach
    </table>
  </div>
  <div class="panel-footer">
    {{$comments->links()}}
  </div>
</div>

@endsection
