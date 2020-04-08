<popular-video-lg inline-template>
  <swiper class="ab-popular-video-lg" :options="swiperOptions">
    @foreach(\App\Model\Post::videos()->orderBy('views_count', 'desc')->limit(5)->get() as $popular)
    <swiper-slide>
      <div class="card" style="background-image: url({{ $popular->heroUrl() }})">
        <div class="card-block">
          <div class="filter">
            <div class="content">
              <div class="vertical-center">
                @if($popular->category)
                <span class="category-info">{{ $popular->category->name }}</span>
                @endif
                <h3 class="title-info">{{ $popular->title }}</h3>
                <div class="description-info">by {{ $popular->user->first_name }} - {{ $popular->created_at->format('d M Y') }} - {{ $popular->views_count }}x dilihat</div>
                <a href="{{ route('post.show', $popular->slug) }}" class=" btn btn-primary btn-round btn-watch btn-inverse">
                  <i class="icon wb-play" aria-hidden="true"></i>
                  Tonton Video
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </swiper-slide>
    @endforeach
    <div class="swiper-pagination" slot="pagination"></div>
    <div class="swiper-nav swiper-button-prev" slot="button-prev">
      <i class="wb-chevron-left"></i>
    </div>
    <div class="swiper-nav swiper-button-next" slot="button-next">
      <i class="wb-chevron-right"></i>
    </div>
  </swiper>
</popular-video-lg>