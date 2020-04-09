<div class="dashboard-comment-list {{ $inPanel ?? '' }}">
  <div class="dashboard-comment-list-info">
    <div class="dashboard-comment-list-left">
      <div class="user-pic">
        <a href="{{ route('users.show', $comment->user->username) }}" class="avatar">
          <v-lazy-image
            class="avatar-holder"
            src="{{ $comment->user->imageUrl() }}"
            src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
            alt="{{ $comment->user->username }}"
          ></v-lazy-image>
        </a>
      </div>
    </div>
    <div class="dashboard-comment-list-right">
      <h5 class="dashboard-comment-list-info-name"><a href="{{ route('users.show', $comment->user->username) }}">{{ $comment->user->name() }}</a></h5>
      <span class="dashboard-comment-list-info-date">{{ $comment->created_at->diffForHumans() }}</span>
      <p class="dashboard-comment-list-info-message">{{ $comment->body }}</p>
    </div>
  </div>
</div>