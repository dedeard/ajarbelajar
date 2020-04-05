@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            @foreach($populars as $popular)
            <div class="swiper-slide">
                <div class="card card-inverse overlay">
                    <img class="card-img overlay-figure img-fluid" src="{{ $popular->heroUrl() }}"
                        alt="{{ $popular->title }}">
                    <div class="card-img-overlay overlay-background text-center vertical-align">
                        <div class="vertical-align-middle">
                            <div class="text-light">{{ $popular->created_at->format('d M Y') }}</div>
                            <h3 class="card-title text-truncate">{{ $popular->title }}</h3>
                            <div class="card-text text-light">
                                {{ $popular->avgRating() }} Bintang dari {{ $popular->reviewCount() }} Review -
                                {{ $popular->views_count }} dilihat - {{ $popular->comments_count }} Komentar
                            </div>
                            <a href="{{ route('post.show', $popular->slug) }}" class=" btn btn-primary btn-sm px-30">
                                @if($popular->type === 'video')
                                Tonton Video
                                @else
                                Baca Artikel
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="my-30"></div>

    @if(count($newVideos))
    <h3>Video Terbaru</h3>
    <div class="row">
        @foreach($newVideos as $post)
        @component('web.components.post_list')
        @slot('post', $post)
        @slot('grid', 4)
        @endcomponent
        @endforeach
        <div class="col-12 text-center pt-30">
            <a href="{{route('video')}}" class="btn btn-primary">TAMPILKAN LEBIH</a>
        </div>
    </div>
    @endif

    @if(count($newArticles))
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
    @endif

    <div class="my-30"></div>
</div>
@endsection
