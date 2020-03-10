<div class="@if(empty($grid)) col-lg-6 @else col-lg-{{$grid}} @endif mb-30">
  <div class="card card-shadow ab-post-card">
    <div class="card-header cover overlay">
      <img class="cover-image overlay-figure overlay-spin" src="{{ $post->thumbUrl() }}" alt="{{ $post->title }}">
    </div>
    <div class="card-block">
      <div class="card-content">
        <h3 class="card-title">{{ $post->title . $post->title }}</h3>
        <p class="card-text">
          <span class="badge badge-primary rounded-0 text-uppercase">{{ $post->type }}</span>
          <small>
            {{ $post->created_at->format('M d, Y') }} | 
            <i class="icon wb-star"></i> {{ $post->avgRating() }}/{{ $post->reviewCount() }} | 
            <i class="icon wb-eye"></i> {{ $post->views_count }} </small>
        </p>
        <p class="card-text">{{ $post->description }}</p>
      </div>
      <div class="card-actions">
        <a class="btn btn-primary btn-outline card-link" href="{{ route('post.show', $post->slug) }}">
          @if($post->type === 'article')
            BACA
          @else
            TONTON
          @endif
        </a>
        <a href="{{ route('post.show', $post->slug) }}#comments">
          <i class="icon wb-chat"></i>
          <span>{{ $post->comments_count }}</span>
        </a>
        <!-- <div class="rating" data-score="4" data-number="5" data-read-only="true"></div> -->
      </div>
    </div>
  </div>
</div>