<div class="new-videos">
  <h3 class="new-videos-title">Video Terbaru</h3>
  <div class="row">
    @foreach(\App\Model\Post::videos()->orderBy('created_at', 'desc')->limit(4)->get() as $video)
    <div class="col-lg-3">
      <a class="new-videos-card" href="{{ route('post.show', $video->slug) }}">
        <div class="overlay-icon-play">
          <i class="wb-play"></i>
        </div>
        <img src="{{ $video->thumbUrl() }}" alt="$video->title" class="img-fluid">
        <img src="{{ $video->user->imageUrl() }}" alt="$video->user->username" class="new-videos-card-avatar">
        @if($video->category)
        <span class="info-category">{{ $video->category->name }}</span>
        @endif
        <h4 class="info-title text-truncate">{{ $video->title }}</h4>
      </a>
    </div>
    @endforeach
  </div>
</div>