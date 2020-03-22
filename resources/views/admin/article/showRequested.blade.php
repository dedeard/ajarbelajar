@extends('admin.layouts.app')
@section('title', $article->title)
@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title text-capitalize">Artikel dari {{ $article->user->name() }}</h3>
    <div class="panel-actions">
      <div class="btn-group">
        <a href="{{ route('admin.articles.requested.accept', $article->id) }}" class="btn btn-outline btn-default btn-sm">Terima</a>
        <a href="{{ route('admin.articles.requested.reject', $article->id) }}" class="btn btn-outline btn-default btn-sm">Tolak</a>
      </div>
    </div>
  </div>
  <div class="card card-shadow rounded-0">
    <img class="card-img-top w-full" src="{{ $article->heroUrl() }}" alt="Card image cap">
    <div class="card-block">
      <h1 class="text-capitalize">{{ $article->title }}</h1>
      <p class="text-primary"><strong>{{ $article->category ? $article->category->name : '' }}</strong></p>
      <p>Oleh {{ $article->user->name() }} Di buat pada {{ $article->created_at->format('d-m-Y') }}</p>
      {!! EditorjsHelp::compile($article->body) !!}
    </div>
  </div>
</div>
@endsection