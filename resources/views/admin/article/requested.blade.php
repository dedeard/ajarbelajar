@extends('admin.layouts.app')
@section('title', 'Daftar Permintaan Artikel')
@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Permintaan Artikel</h3>
  </div>
  <div class="panel-body">
    <table id="table-requested-article" data-height="500" data-mobile-responsive="true">
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
        @foreach($articles as $article)
        <tr>
          <td>{{ $article->id }}</td>
          <td>{{ $article->user->username }}</td>
          <td>{{ $article->title }}</td>
          <td>{{ $article->requested_at }}</td>
          <td class="text-center">
            <a href="{{ route('admin.articles.requested.show', $article->id) }}">Lihat</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection