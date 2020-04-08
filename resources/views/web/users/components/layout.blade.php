<div class="container-fluid minitutor-page-layout">
  <div class="minitutor-page-card">
    <div class="minitutor-page-card-left">
      <div class="user-pic">
        <a href="{{ route('users.show', $user->username) }}" class="avatar">
          <img src="{{ $user->imageUrl() }}" alt="{{ $user->username }}" class="avatar-holder">
        </a>
      </div>
    </div>
    <div class="minitutor-page-card-center">
      <h2 class="info-name text-truncate"><a href="{{ route('users.show', $user->username) }}">{{ $user->name() }}</a></h2>
      <span class="info-username text-truncate"><a href="{{ route('users.show', $user->username) }}">{{ '@' . $user->username }}</a></span>
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
    </div>
    <div class="minitutor-page-card-right">
      @if($user->minitutor && $user->minitutor->active)
        <a href="{{ route('minitutor.show', $user->username) }}" class="btn btn-primary btn-sm">Lihat Minitutor</a>
      @endif
    </div>
  </div>

  <?php
  $userLinks = [
    [
      'route' => 'users.activity',
      'name' => 'Aktifitas',
      'icon' => 'wb-graph-up'
    ],
    [
      'route' => 'users.following',
      'name' => 'Diikuti',
      'icon' => 'wb-star',
      'badge' => $user->subscriptions(\App\Model\Minitutor::class)->where('active', 1)->count()
    ],
    [
      'route' => 'users.favorite',
      'name' => 'Favorit',
      'icon' => 'wb-heart',
      'badge' => $user->favorites(\App\Model\Post::class)->where('draf', 0)->count()
    ],
  ];
?>
 
  <ul class="my-dashboard-nav nav-quick nav-quick-sm row">
    @foreach($userLinks as $link)
    <li class="nav-item col">
      <a class="nav-link {{ Route::is($link['route']) ? 'active' : '' }}" href="{{ route($link['route'], $user->username) }}">
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