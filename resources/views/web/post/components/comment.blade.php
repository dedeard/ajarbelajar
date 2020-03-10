<div class="comments" id="comments">
  <div class="h3 card-title">Komentar {{ $post->comments->count() }}</div>
  <div class="comment-lists">
    @foreach($post->comments as $comment)
    <div class="comment media">
      <div class="pr-20">
        @if($comment->user->minitutor && $comment->user->minitutor->active)
        <a class="avatar avatar-lg" href="#">
          <img src="{{ $comment->user->imageUrl() }}" alt="$comment->user->username">
        </a>
        @else
        <span class="avatar avatar-lg">
          <img src="{{ $comment->user->imageUrl() }}" alt="$comment->user->username">
        </span>
        @endif
      </div>
      <div class="media-body">
        <div class="comment-body">
          @if($comment->user->minitutor && $comment->user->minitutor->active)
          <a href="#" class="comment-author text-capitalize">{{$comment->user->name()}} <small class="text-primary"><i class="icon wb-check-circle"></i></small></a>
          @else
          <span class="comment-author text-capitalize">{{$comment->user->name()}}</span>
          @endif
          <div class="comment-meta">
            <span class="date">{{ $comment->created_at->diffForHumans() }}</span>
          </div>
          <div class="comment-content">
            <p>{{ $comment->body }}</p>
            @auth
              @if(Auth::user()->isAdmin())
                @if(!$comment->approved)
                <a href="{{ route('post.comment.approve', [$post->id, $comment->id]) }}" class="btn btn-primary btn-sm">Terima</a>
                @endif
                <button delete-confirm type="button" data-target="#form-delete-comment-{{$comment->id}}" class="btn btn-danger btn-sm">Hapus</button>
                <form action="{{ route('post.comment.destroy', [$post->id, $comment->id]) }}" method="post" id="form-delete-comment-{{$comment->id}}">
                  @csrf
                  @method('delete')
                </form>
              @endif
            @endauth
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
      <textarea class="form-control" name="body" rows="5" placeholder="Comment here"></textarea>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
        <span class="ladda-label">Komen</span>
      </button>
    </div>
  </form>
</div>