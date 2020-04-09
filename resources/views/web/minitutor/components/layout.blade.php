<div class="container-fluid minitutor-page-layout">
  <div class="minitutor-page-card">
    <div class="minitutor-page-card-left">
      <div class="user-pic">
        <a href="{{ route('users.show', $minitutor->user->username) }}" class="avatar">
          <v-lazy-image
            class="avatar-holder"
            src="{{ $minitutor->user->imageUrl() }}"
            src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
            alt="{{ $minitutor->user->username }}"
          ></v-lazy-image>
          <span class="user-pic-points">{{ $minitutor->points }} Poin</span>
        </a>
      </div>
    </div>
    <div class="minitutor-page-card-center">
      <h2 class="info-name text-truncate"><a href="{{ route('users.show', $minitutor->user->username) }}">{{ $minitutor->user->name() }}</a></h2>
      <span class="info-username text-truncate"><a href="{{ route('users.show', $minitutor->user->username) }}">{{ '@' . $minitutor->user->username }}</a></span>
      <div class="social-info">
      @if($minitutor->user->website_url)
        <a href="{{ $minitutor->user->website_url }}" rel="noreferrer" target="_blank">
          <i class="icon wb-globe"></i>
        </a>
        @endif
        @if($minitutor->user->twitter_url)
        <a href="{{ $minitutor->user->twitter_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-twitter"></i>
        </a>
        @endif
        @if($minitutor->user->instagram_url)
        <a href="{{ $minitutor->user->instagram_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-instagram"></i>
        </a>
        @endif
        @if($minitutor->user->facebook_url)
        <a href="{{ $minitutor->user->facebook_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-facebook"></i>
        </a>
        @endif
        @if($minitutor->user->youtube_url)
        <a href="{{ $minitutor->user->youtube_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-youtube"></i>
        </a>
        @endif
      </div>
    </div>
    <div class="minitutor-page-card-right">
      @if(Auth::user() && Auth::user()->hasSubscribed($minitutor))
        <a href="{{ route('followable.unfollow', $minitutor->user->id) }}" class="btn btn-danger btn-sm">Berhenti Mengikuti</a>
      @else
        <a href="{{ route('followable.follow', $minitutor->user->id) }}" class="btn btn-primary btn-sm">Ikuti Minitutor</a>
      @endif
    </div>
  </div>

  <?php
  $minitutorNavLinks = [
    [
      'route' => 'minitutor.info',
      'name' => 'Info',
      'icon' => 'wb-info'
    ],
    [
      'route' => 'minitutor.videos',
      'name' => 'Video',
      'icon' => 'wb-video',
      'badge' => $minitutor->posts()->where('type', 'video')->where('draf', 0)->count()
    ],
    [
      'route' => 'minitutor.articles',
      'name' => 'Article',
      'icon' => 'wb-order',
      'badge' => $minitutor->posts()->where('type', 'article')->where('draf', 0)->count()
    ],
    [
      'route' => 'minitutor.followers',
      'name' => 'Pengikut',
      'icon' => 'wb-users',
      'badge' => $minitutor->subscribers()->count()
    ],
  ];
?>
 
  <ul class="minitutor-layout-nav nav-quick nav-quick-sm row">
    @foreach($minitutorNavLinks as $link)
    <li class="nav-item col">
      <a class="nav-link {{ Route::is($link['route']) ? 'active' : '' }}" href="{{ route($link['route'], $minitutor->user->username) }}">
        <i class="icon {{ $link['icon'] }}"></i>
        <span class="d-lg-block d-none">{{ $link['name'] }}</span>
        @if(isset($link['badge']) && $link['badge'] > 0)
        <span class="badge badge-sm badge-dark m-3">{{ $link['badge'] }}</span>
        @endif
      </a>
    </li>
    @endforeach
  </ul>

  {{ $slot }}
</div>