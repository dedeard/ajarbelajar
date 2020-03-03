@extends('web.layouts.app')
@section('title', 'Home')
@section('content')
<div class="container-fluid mt-15">
  <div class="owl-carousel owl-carousel-landing">
    @foreach($populars as $popular)
    <div class="card card-inverse overlay">
      @if($popular->type === 'video')
      <img class="card-img overlay-figure img-fluid" src="/storage/video/hero/{{ $popular->hero }}" alt="...">
      @else
      <img class="card-img overlay-figure img-fluid" src="/storage/article/hero/{{ $popular->hero }}" alt="...">
      @endif
      <div class="card-img-overlay overlay-background text-center vertical-align">
        <div class="vertical-align-middle">
          <div class="card-text card-divider">
            <span>{{ $popular->created_at->format('d M Y') }}</span>
          </div>
          <h3 class="card-title mb-20">{{ $popular->title }}</h3>
          <p class="text-white"><i class="wb wb-eye"></i> {{ $popular->views_count }} | <i class="wb wb-chat"></i> {{ $popular->comments_count }}</p>
          @if($popular->type === 'video')
          <a href="{{ route('post.video', $popular->slug) }}" class=" btn btn-outline btn-inverse">TONTON VIDEO</a>
          @else
          <a href="{{ route('post.article', $popular->slug) }}" class=" btn btn-outline btn-inverse">BACA ARTIKEL</a>
          @endif
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="my-30"></div>
  <h3>Artikel Terbaru</h3>
  <div class="row">
    @foreach($newArticles as $post)
      @component('web.components.post_list')
      @slot('post', $post)
      @slot('grid', 4)
      @endcomponent
    @endforeach
    <div class="col-12 text-center pt-30">
      <a href="{{route('article')}}" class="btn btn-primary">TAMPILKAN LEBIH</a>
    </div>
  </div>
  <div class="my-30"></div>
  <h3>Video Terbaru</h3>
  <div class="row">
    @foreach($newVideos as $post)
      @component('web.components.post_list')
      @slot('post', $post)
      @slot('grid', 4)
      @endcomponent
    @endforeach
    <div class="col-12 text-center pt-30">
      <a href="{{route('article')}}" class="btn btn-primary">TAMPILKAN LEBIH</a>
    </div>
  </div>
  <div class="my-30"></div>
</div>
@endsection