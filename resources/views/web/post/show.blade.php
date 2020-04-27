@extends('web.layouts.app')
@section('content')

<div class="container-fluid">
  <div class="post-read-card">
    <div class="post-read-card-content">
      <article>
        <v-lazy-image
          src="{{ $post->heroUrl() }}"
          src-placeholder="{{ asset('img/placeholder/post-lg.jpg') }}"
          alt="{{ $post->title }}"
          class="hero"
        ></v-lazy-image>
        <div class="post-detail">
          <div class="post-info">
            <span class="info">Diposting di {{ $post->type === 'article' ? 'Artikel' : 'Video' }} pada {{ $post->created_at->format('d M Y') }}</span>
            <span class="v-divider">|</span>
            <span class="info"><i class="wb-eye"></i> {{$post->views_count}}</span>
          </div>
          <div class="post-action">
          @if(Auth::user() && $post->isFavoritedBy(Auth::user()))
          <a href="{{ route('favorite.destroy', $post->id) }}" class="btn btn-danger btn-sm d-none d-md-inline-block"><i class="wb-heart"></i> Hapus dari Favorit</a>
          <a href="{{ route('favorite.destroy', $post->id) }}" class="btn btn-danger btn-xs btn-icon d-block d-md-none"><i class="wb-heart"></i></a>
          @else
          <a href="{{ route('favorite.create', $post->id) }}" class="btn btn-default btn-outline indigo-600 btn-sm d-none d-md-inline-block"><i class="wb-heart"></i> Tambah ke favorite</a>
          <a href="{{ route('favorite.create', $post->id) }}" class="btn btn-default btn-outline indigo-600 btn-xs btn-icon d-block d-md-none"><i class="wb-heart"></i></a>
          @endif
          </div>
        </div>
        <div class="post-rating">
          <star-rating
            class="post-rating-star"
            :rating="{{ $post->avgRating() }}"
            :read-only="true"
            :increment="0.01"
            :star-size="14"
            text-class="mt-0 font-weight-light"
          ></star-rating>
          <span class="post-rating-text">dari {{ $post->reviewCount() }} Feedback</span>
        </div>
        <div class="post-title">
          <h1>{{ $post->title }}</h1>
        </div>
        @if($post->category)
        <div class="post-category">
          <a href="{{ route('category.show', $post->category->slug) }}">{{ $post->category->name }}</a>
        </div>
        @endif
        @auth
          <div class="post-body">
            {!! EditorjsHelp::compile($post->body) !!}
          </div>
          @if($post->tags->count())
          <div class="post-tags">
            <div class="post-tags-title">Tags</div>
            @foreach($post->tags as $tag)
              <a href="{{ route('tags', $tag->slug) }}" class="btn btn-xs btn-default">{{ $tag->name }}</a>
            @endforeach
          </div>
          @endif
        @else
          <div class="post-body text-center">
            <p class="lead my-15">Anda harus login untuk mengakses postingan ini.</p>
            <a href="{{ route('login') }}" class="btn btn-primary px-30">LOGIN</a>
          </div>
        @endauth
      </article>
      @auth
        @component('web.post.components.review')
          @slot('post', $post)
          @slot('review', $review)
        @endcomponent

        @component('web.post.components.comment')
          @slot('post', $post)
        @endcomponent
      @endauth
    </div>
    <div class="post-read-card-side">
      @component('web.post.components.creator_card')
        @slot('user', $post->user)
      @endcomponent
    </div>
  </div>
</div>

@endsection
