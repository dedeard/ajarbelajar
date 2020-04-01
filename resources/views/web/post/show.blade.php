@extends('web.layouts.app')
@section('content')
@component('web.post.components.layoutWrapper')

@slot('post', $post)
<div class="card" style="font-size: 16px">
  <img class="card-img-top img-fluid w-full" src="{{ $post->heroUrl() }}" alt="{{ $post->title }}">
  <div class="card-block">
    <div class="row text-center">
      <div class="col-lg-6">
        @if(Auth::user() && $post->isFavoritedBy(Auth::user()))
        <a href="{{ route('favorite.destroy', $post->id) }}" class="text-danger btn btn-default btn-outline"><i class="icon wb-heart"></i> Hapus dari daftar favorit</a>
        @else
        <a href="{{ route('favorite.create', $post->id) }}" class="text-secondary btn btn-default btn-outline"><i class="icon wb-heart"></i> Tambah ke daftar Favoritkan</a>
        @endif
      </div>
      <div class="col-lg-6">
      <a href="#review" class="btn btn-warning btn-outline"><i class="icon wb-star"></i> {{ $post->avgRating() }} bintang dari {{ $post->reviewCount() }} ulasan</a>
      </div>
    </div>
    
  </div>
  <hr class="m-0">
  <article class="card-block">
    <h1 class="card-title display-4">{{ $post->title }}</h1>
    <hr class="m-0">
      <p class="my-15">
        dari <a class="text-dark" href="{{ route('minitutor.show', $post->user->username) }}">{{ $post->user->name() }}</a> - 
        @if($post->category) <a class="text-dark" href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a> - @endif
        {{ $post->created_at->format('d M Y') }}        
      </p>
    <hr class="m-0">
    {!! EditorjsHelp::compile($post->body) !!}
  </article>
  <hr class="m-0">
  <div class="card-block">
    <div class="h4">Tag</div>
    @foreach($post->tags as $tag)
      <a href="{{ route('tags', $tag->slug) }}" class="btn btn-xs btn-primary">{{ $tag->name }}</a>
    @endforeach
  </div>
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
