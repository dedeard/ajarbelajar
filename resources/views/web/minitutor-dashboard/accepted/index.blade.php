@extends('web.layouts.app')
@section('content')


@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  @if($accepteds->total() || request()->input('search'))
    <form method="get" class="form-search-lg">
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari Postingan yang diterima.." value="{{ request()->input('search') }}">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
        </span>
      </div>
    </form>
  @foreach($accepteds as $post)
  <div class="ab-dashboard-post-list">
    <div class="ab-dashboard-post-list-left">
      <div class="ab-dashboard-post-list-thumb">
        <img src="{{ $post->thumbUrl() }}" alt="{{ $post->title }}">
        @if($post->type === 'article')
        <span class="post-type">
          Artikel
        </span>
        @else
        <span class="post-type red">
          Video
        </span>
        @endif
      </div>
    </div>
    <div class="ab-dashboard-post-list-right">
      <span class="info-time">{{ $post->created_at->format('d M Y') }}</span>
      <h3 class="info-title">{{ $post->title }}</h3>
      @if($post->category)
      <span class="category-info">{{ $post->category->name }}</span>
      @endif
      <div class="more-info">
        <span><i class="icon wb-star"></i> {{ $post->avgRating() }} Bintang dari {{ $post->reviewCount() }} Reviewer</span>
        <span><i class="icon wb-chat"></i> {{ $post->comments_count }} Komentar</span>
        <span><i class="icon wb-eye"></i> {{ $post->views_count }}x @if($post->type === 'article') Dibaca @else Ditonton @endif</span>
        <span><i class="icon wb-globe"></i> Status <strong>{{ $post->draf ? 'Draf' : 'Publik' }}</strong></span>
      </div>
      <div class="actions mt-10">
        <div class="row">
          <div class="col-6">
            <a href="{{route('dashboard.minitutor.accepted.preview', $post->slug)}}" class="btn btn-primary btn-block btn-sm">Detail & Preview</a>
          </div>
          <div class="col-6">
            <a href="{{route('post.show', $post->slug)}}" class="btn btn-primary btn-block btn-sm">Publik Preview</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endforeach
  @if(!$accepteds->total())
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
  </div>
  @endif
  <div class="card card-block mb-15 empty-none">
    {{ $accepteds->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Belum ada Artikel atau Video yang diterima.</h3>
  </div>
  @endif
</div>
@endcomponent
@endsection