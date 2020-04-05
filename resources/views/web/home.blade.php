@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
    @include('web.partials.popular-video-lg')
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
