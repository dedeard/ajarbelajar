<div class="panel panel-body p-10 p-md-20">
  <div class="comments" id="comments">
    <div class="h3 card-title">Komentar {{ $post->comments->count() }}</div>
    <div class="comment-lists">
      @foreach($post->comments as $comment)
      <div class="comment media">
        <div class="pr-20">
          <a href="{{ route('users.show', $comment->user->username) }}" class="avatar avatar-lg">
            <v-lazy-image
              src="{{ $comment->user->imageUrl() }}"
              src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
              alt="{{ $comment->user->username }}"
            ></v-lazy-image>
          </a>
        </div>
        <div class="media-body">
          <div class="comment-body">
            <a href="{{ route('users.show', $comment->user->username) }}" class="comment-author text-capitalize">{{$comment->user->name()}}
              @if($comment->user->minitutor && $comment->user->minitutor->active)
                <small class="indigo-600"><i class="icon wb-check-circle"></i></small>
              @endif
            </a>
            <div class="comment-meta">
              <span class="date">{{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <div class="comment-content">
              <p>{{ $comment->body }}</p>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <form class="comments-add mt-35" action="{{ route('post.comment.store', $post->id) }}" method="post">
      @csrf
      <h3 class="mb-35">Tulis Komentar</h3>
      <div class="form-group">
        <textarea class="form-control" name="body" rows="5" placeholder="Komentar..."></textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
          <span class="ladda-label">Komentari</span>
        </button>
      </div>
    </form>
  </div>
</div>