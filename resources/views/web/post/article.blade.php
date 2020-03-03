@extends('web.layouts.app')
@section('title', $article->title)
@section('meta')
  <meta name="description" content="{{ $article->description }}">
@endsection
@section('content')
@component('web.post.components.layoutWrapper')
@slot('post', $article)
<div class="card" style="font-size: 16px">
  <img class="card-img-top img-fluid w-full" src="{{ $article->heroUrl() }}" alt="{{ $article->title }}">
  <div class="card-block">
    <p class="m-0 small text-muted">
      Dibuat pada, {{ $article->created_at->format('d M Y') }} &nbsp; | &nbsp; <i class="icon wb-eye"></i>  {{ $article->views_count }}
      &nbsp; | &nbsp;
      @if(Auth::user() && $article->isFavoritedBy(Auth::user()))
      <a href="{{ route('favorite.destroy', [$article->id, 'article']) }}" class="btn btn-icon btn-default btn-outline">
        <i class="icon wb-heart text-danger"></i>
      </a>
      @else
      <a href="{{ route('favorite.create', [$article->id, 'article']) }}" class="btn btn-icon btn-default btn-outline">
        <i class="icon wb-heart"></i>
      </a>
      @endif
    </p>
  </div>
  <hr class="m-0">
  <article class="card-block">
    <h1 class="card-title display-4">{{ $article->title }}</h1>
    @if($article->category)
      <p class="lead">Kategori <a href="#">{{ $article->category->name }}</a></p>
    @endif
    {!! Helper::compileEditorJs($article->body) !!}
  </article>
  <hr class="m-0">
  <div class="card-block">
    @component('web.post.components.comment')
      @slot('target', 'article')
      @slot('post', $article)
    @endcomponent
  </div>
</div>
@endcomponent
@endsection
