@extends('admin.layouts.app')
@section('title', 'Daftar Artikel')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Artikel</h3>
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
        @foreach($articles as $article)
        <tr>
          <td>{{ $article->id }}</td>
          <td>{{ $article->user->name() }}</td>
          <td>{{ $article->title }}</td>
          <td>{{ $article->draf ? 'Draf' : 'Public' }}</td>
          <td>{{ $article->created_at->format('d/m/Y') }}</td>
          <td>{{ $article->updated_at->format('d/m/Y') }}</td>
          <td class="text-center">
            <a href="{{ route('admin.articles.edit', $article->id) }}">Edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $articles->links() }}
  </div>
</div>
@endsection
