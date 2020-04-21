<div class="ab-post-list">
  <div class="ab-post-list-left">
    <div class="ab-post-list-thumb">
        <v-lazy-image
          src="{{ $post->thumbUrl() }}"
          src-placeholder="{{ asset('img/placeholder/post-sm.jpg') }}"
          alt="{{ $post->title }}"
        ></v-lazy-image>
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
  <div class="ab-post-list-right">
    <span class="info-time">{{ $post->created_at->format('d M Y') }}</span>
    <h3 class="info-title"><a rel="nofollow" href="{{route('post.show', $post->slug)}}">{{ $post->title }}</a></h3>
    @if($post->category)
    <span class="category-info">{{ $post->category->name }}</span>
    @endif
    <div class="more-info">
      <span><i class="icon wb-star"></i> {{ $post->avgRating() }} Bintang dari {{ $post->reviewCount() }} Reviewer</span>
      <span><i class="icon wb-chat"></i> {{ $post->comments_count }} Komentar</span>
      <span><i class="icon wb-eye"></i> {{ $post->views_count }}x @if($post->type === 'article') Dibaca @else Ditonton @endif</span>
      <span><i class="icon wb-user"></i> Dari <a href="{{ route('minitutor.show', $post->user->username) }}">{{ $post->user->name() }}</a></span>
    </div>
    <div class="actions mt-10">
      <div class="row">
        <div class="col-6">
          <a rel="nofollow" href="{{route('post.show', $post->slug)}}" class="btn btn-primary btn-block btn-sm">
            @if($post->type === 'article')
              <i class="wb-book"></i> Baca Artikel
            @else
              <i class="wb-play"></i> Tonton Video
            @endif
          </a>
        </div>
        <div class="col-6">
          @if(Auth::user() && $post->isFavoritedBy(Auth::user()))
          <a rel="nofollow" href="{{ route('favorite.destroy', $post->id) }}" class="btn btn-danger btn-outline btn-block btn-sm"><i class="icon wb-heart"></i> Hapus Favorit</a>
          @else
          <a rel="nofollow" href="{{ route('favorite.create', $post->id) }}" class="btn btn-danger btn-outline btn-block btn-sm"><i class="icon wb-heart"></i> Tambah Favorit</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>