<div class="new-articles">
  <h3 class="new-articles-title">Artikel Terbaru</h3>
  <div class="row">
    @foreach(\App\Models\Post::articles()->orderBy('created_at', 'desc')->limit(4)->get() as $video)
    <div class="col-lg-3">
      <a class="new-articles-card" rel="nofollow" href="{{ route('post.show', $video->slug) }}">
        <div class="overlay-icon-play">
          <i class="wb-library"></i>
        </div>
        <v-lazy-image
          src="{{ $video->thumbUrl() }}"
          src-placeholder="{{ asset('img/placeholder/post-sm.jpg') }}"
          alt="{{ $video->title }}"
          class="img-fluid"
        ></v-lazy-image>
        <v-lazy-image
          class="new-articles-card-avatar"
          src="{{ $video->user->imageUrl() }}"
          src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
          alt="{{ $video->user->username }}"
        ></v-lazy-image>
        @if($video->category)
        <span class="info-category">{{ $video->category->name }}</span>
        @endif
        <h4 class="info-title text-truncate">{{ $video->title }}</h4>
      </a>
    </div>
    @endforeach
  </div>
</div>
