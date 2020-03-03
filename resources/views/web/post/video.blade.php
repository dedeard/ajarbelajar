@extends('web.layouts.app')
@section('title', $video->title)
@section('content')
@section('meta')
<meta name="description" content="{{ $video->description }}">
@endsection
@component('web.post.components.layoutWrapper')
@slot('post', $video)
<div class="card" style="font-size: 16px">
  <img class="card-img-top img-fluid w-full" src="{{ $video->heroUrl() }}" alt="{{ $video->title }}">
  <div class="card-block">
    <p class="m-0 small text-muted">
      Dibuat pada, {{ $video->created_at->format('d M Y') }} &nbsp; | &nbsp; <i class="icon wb-eye"></i>  {{ $video->views_count }}
      @if(Auth::user() && $video->isFavoritedBy(Auth::user()))
      <a href="{{ route('favorite.destroy', [$video->id, 'video']) }}" class="btn btn-icon btn-default btn-outline">
        <i class="icon wb-heart text-danger"></i>
      </a>
      @else
      <a href="{{ route('favorite.create', [$video->id, 'video']) }}" class="btn btn-icon btn-default btn-outline">
        <i class="icon wb-heart"></i>
      </a>
      @endif
    </p>
  </div>
  <hr class="m-0">
  <article class="card-block">
    <h1 class="card-title display-4">{{ $video->title }}</h1>
    @if($video->category)
      <p class="lead">Kategori <a href="#">{{ $video->category->name }}</a></p>
    @endif
    {!! Helper::compileEditorJs($video->body) !!}
  </article>
  <hr class="m-0">
  <div class="card-block">
    @component('web.post.components.comment')
      @slot('target', 'video')
      @slot('post', $video)
    @endcomponent
  </div>
</div>
@endcomponent
@endsection
