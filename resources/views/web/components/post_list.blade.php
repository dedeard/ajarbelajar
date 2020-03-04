<div class="@if(empty($grid)) col-lg-6 @else col-lg-{{$grid}} @endif mb-30">
  <div class="card card-shadow ab-post-card">
    <div class="card-header cover overlay">
      @if($post->type === 'article')
      <img class="cover-image overlay-figure overlay-spin" src="{{ $post->hero ? asset('storage/article/hero/thumb/' . $post->hero) : asset('img/placeholder/post-sm.jpg') }}" alt="{{ $post->title }}">
      @else
      <img class="cover-image overlay-figure overlay-spin" src="{{ $post->hero ? asset('storage/video/hero/thumb/' . $post->hero) : asset('img/placeholder/post-sm.jpg') }}" alt="{{ $post->title }}">
      @endif
    </div>
    <div class="card-block">
      <div class="card-content">
        <h3 class="card-title">{{ $post->title . $post->title }}</h3>
        <p class="card-text">
          <span class="badge badge-primary rounded-0 text-uppercase">{{ $post->type }}</span>
          <small>{{ $post->created_at->format('M d, Y') }} | <i class="icon wb-eye"></i> {{ $post->views_count }}</small>
        </p>
        <p class="card-text">{{ $post->description }}</p>
      </div>
      <div class="card-actions">
        @if($post->type === 'article')
        <a class="btn btn-primary btn-outline card-link" href="{{ route('post.article', $post->slug) }}">BACA</a>
        <a href="{{ route('post.article', $post->slug) }}#comments">
          <i class="icon wb-chat"></i>
          <span>{{ $post->comments_count }}</span>
        </a>
        @else
        <a class="btn btn-primary btn-outline card-link" href="{{ route('post.video', $post->slug) }}">TONTON</a>
        <a href="{{ route('post.video', $post->slug) }}#comments">
          <i class="icon wb-chat"></i>
          <span>{{ $post->comments_count }}</span>
        </a>
        @endif
        <!-- <div class="rating" data-score="4" data-number="5" data-read-only="true"></div> -->
      </div>
    </div>
  </div>
</div>