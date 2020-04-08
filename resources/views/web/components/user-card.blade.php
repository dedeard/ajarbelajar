<div class="user-card-sm">
  <div class="user-pic">
    <a href="{{ route('users.show', $user->username) }}" class="avatar">
      <img src="{{ $user->imageUrl() }}" alt="{{ $user->username }}" class="avatar-holder">
    </a>
  </div>
  <div class="info">
    <h4 class="info-name text-truncate"><a href="{{ route('users.show', $user->username) }}">{{ $user->name() }}</a></h4>
    <span class="info-username text-truncate"><a href="{{ route('users.show', $user->username) }}">{{ '@' . $user->username }}</a></span>
  </div>
  <div class="social-info">
    @if($user->website_url)
    <a href="{{ $user->website_url }}" target="_blank">
      <i class="icon wb-globe"></i>
    </a>
    @endif
    @if($user->twitter_url)
    <a href="{{ $user->twitter_url }}" target="_blank">
      <i class="icon socicon-twitter"></i>
    </a>
    @endif
    @if($user->instagram_url)
    <a href="{{ $user->instagram_url }}" target="_blank">
      <i class="icon socicon-instagram"></i>
    </a>
    @endif
    @if($user->facebook_url)
    <a href="{{ $user->facebook_url }}" target="_blank">
      <i class="icon socicon-facebook"></i>
    </a>
    @endif
    @if($user->youtube_url)
    <a href="{{ $user->youtube_url }}" target="_blank">
      <i class="icon socicon-youtube"></i>
    </a>
    @endif
  </div>
  <div class="actions">
    <a href="{{ route('users.show', $user->username) }}" class="btn btn-primary btn-sm px-30">Lihat Profile Pengguna</a>
  </div>
</div>