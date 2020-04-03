<div class="@if(empty($grid)) col-lg-6 @else col-lg-{{$grid}} @endif mb-30">
  <div class="card card-shadow ab-post-card">
    <div class="card-header cover overlay">
      <img class="cover-image overlay-figure overlay-spin" src="{{ $post->thumbUrl() }}" alt="{{ $post->title }}">
    </div>
    <a href="{{ route('post.show', $post->slug) }}" class="btn btn-primary btn-sm m-0 rounded-0 text-uppercase">
      @if($post->type === 'article')
        Baca Artikel
      @else
        Tonton Video
      @endif
    </a>
    <div class="card-block">
      <div class="card-content">
        {{ $post->created_at->format('M d, Y') }}
        <h3 class="card-title"> <a href="{{route('post.show', $post->slug)}}" class="text-dark">{{ $post->title }}</a></h3>
        <div class="card-text small mb-15">
          {{ $post->avgRating() }} Bintang dari {{ $post->reviewCount() }} Review - {{ $post->views_count }} dilihat - {{ $post->comments_count }} Komentar
        </div>
        <p class="card-text">{{ $post->description }}</p>
      </div>
    </div>
  </div>
</div>