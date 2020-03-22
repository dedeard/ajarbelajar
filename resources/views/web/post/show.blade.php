@extends('web.layouts.app')
@section('title', $post->title)
@section('content')
@section('meta')
<meta name="description" content="{{ $post->description }}">
@endsection
@component('web.post.components.layoutWrapper')

@slot('post', $post)
<div class="card" style="font-size: 16px">
  <img class="card-img-top img-fluid w-full" src="{{ $post->heroUrl() }}" alt="{{ $post->title }}">
  <div class="card-block">
    <p class="m-0 small text-muted">
      Dibuat pada, {{ $post->created_at->format('d M Y') }} &nbsp; | 
      &nbsp; <span><i class="icon wb-eye text-primary"></i></span>  {{ $post->views_count }} &nbsp; | 
      &nbsp; </span><i class="icon wb-star text-warning"></i></span>  {{ $post->avgRating() }} / {{ $post->reviewCount() }} &nbsp; | 
      &nbsp; @if(Auth::user() && $post->isFavoritedBy(Auth::user()))
      <a href="{{ route('favorite.destroy', $post->id) }}" class="text-danger"><i class="icon wb-heart"></i></a>
      @else
      <a href="{{ route('favorite.create', $post->id) }}" class="text-secondary"><i class="icon wb-heart"></i></a>
      @endif
    </p>
  </div>
  <hr class="m-0">
  <article class="card-block">
    <h1 class="card-title display-4">{{ $post->title }}</h1>
    @if($post->category)
      <p class="lead">Kategori <a href="#">{{ $post->category->name }}</a></p>
    @endif
    {!! EditorjsHelp::compile($post->body) !!}
  </article>
  <hr class="m-0">
  <div class="card-block">
    @component('web.post.components.review')
      @slot('post', $post)
      @slot('review', $review)
    @endcomponent
  </div>
  <hr class="m-0">
  <div class="card-block">
    @component('web.post.components.comment')
      @slot('post', $post)
    @endcomponent
  </div>
</div>
@endcomponent
@endsection
