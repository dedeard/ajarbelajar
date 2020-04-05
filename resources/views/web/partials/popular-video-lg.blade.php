<div class="swiper-container ab-popular-video-lg" id="ab-popular-video-lg">
  <div class="swiper-wrapper">
    @foreach(\App\Model\Post::videos()->orderBy('views_count', 'desc')->limit(3)->get() as $popular)
    <div class="swiper-slide">
      <div class="card" style="background-image: url({{ $popular->heroUrl() }})">
        <div class="card-block">
          <div class="filter">
            <div class="content">
              <div class="vertical-center">
                <h3 class="title-info">{{ $popular->title }}</h3>
                <div class="description-info">by {{ $popular->user->first_name }} - {{ $popular->created_at->format('d M Y') }} - {{ $popular->views_count }}x dilihat</div>
                <a href="{{ route('post.show', $popular->slug) }}" class=" btn btn-primary btn-round btn-watch">
                  <i class="icon wb-play" aria-hidden="true"></i>
                  Tonton Video
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="swiper-pagination"></div>
  <div class="swiper-nav swiper-button-prev">
    <i class="icon wb-chevron-left"></i>
  </div>
  <div class="swiper-nav swiper-button-next">
    <i class="wb-chevron-right"></i>
  </div>
</div>