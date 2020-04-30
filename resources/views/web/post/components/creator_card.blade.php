<div class="creator-card">
  <div class="creator-card-body">
    <div class="user-pic">
      <a href="{{ route('minitutor.show', $user->username) }}" class="avatar">
        <v-lazy-image
          class="avatar-holder"
          src="{{ $user->imageUrl() }}"
          src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
          alt="{{ $user->username }}"
        ></v-lazy-image>
        <span class="minitutor-point">{{ $user->points }} Poin</span>
      </a>
    </div>
    <div class="user-info">
      <h4 class="info-name text-truncate"><a href="{{ route('minitutor.show', $user->username) }}">{{ $user->name() }}</a></h4>
      <span class="info-username"><a href="{{ route('users.show', $user->username) }}">{{ '@' . $user->username }}</a></span>
    </div>
    <div class="social-info">
    @if($user->website_url)
        <a href="{{ $user->website_url }}" rel="noreferrer" target="_blank">
          <i class="icon wb-globe"></i>
        </a>
        @endif
        @if($user->twitter_url)
        <a href="{{ $user->twitter_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-twitter"></i>
        </a>
        @endif
        @if($user->instagram_url)
        <a href="{{ $user->instagram_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-instagram"></i>
        </a>
        @endif
        @if($user->facebook_url)
        <a href="{{ $user->facebook_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-facebook"></i>
        </a>
        @endif
        @if($user->youtube_url)
        <a href="{{ $user->youtube_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-youtube"></i>
        </a>
        @endif
    </div>
    <div class="actions">
      @if(Auth::user() && Auth::user()->hasSubscribed($user->minitutor))
        <a href="{{ route('followable.unfollow', $user->id) }}" class="btn btn-danger btn-sm">Berhenti Mengikuti</a>
      @else
        <a href="{{ route('followable.follow', $user->id) }}" class="btn btn-primary btn-sm">Ikuti Minitutor</a>
      @endif
    </div>
  </div>
  <div class="creator-card-foot">
    <p>Postingan ditulis oleh {{ $user->name() }}</p>
  </div>
</div>