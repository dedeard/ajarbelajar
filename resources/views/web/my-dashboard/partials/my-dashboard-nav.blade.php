<?php
  $myDashboardLinks = [
    [
      'route' => 'dashboard.me.activity.index',
      'name' => 'Aktifitas',
      'icon' => 'wb-graph-up'
    ],
    [
      'route' => 'dashboard.me.edit.index',
      'name' => 'Edit Profile',
      'icon' => 'wb-user-circle'
    ],
    [
      'route' => 'dashboard.me.following.index',
      'name' => 'Diikuti',
      'icon' => 'wb-star',
      'badge' => Auth::user()->subscriptions(\App\Model\Minitutor::class)->where('active', 1)->count()
    ],
    [
      'route' => 'dashboard.me.favorite.index',
      'name' => 'Favorit',
      'icon' => 'wb-heart',
      'badge' => Auth::user()->favorites(\App\Model\Post::class)->where('draf', 0)->count()
    ],
  ];
?>

<div class="container-fluid">  
  <ul class="my-dashboard-nav nav-quick nav-quick-sm row">
    @foreach($myDashboardLinks as $link)
    <li class="nav-item col">
      <a class="nav-link {{ Route::is($link['route']) ? 'active' : '' }}" href="{{ route($link['route']) }}">
        <i class="icon {{ $link['icon'] }}"></i>
        <span class="d-lg-block d-none">{{ $link['name'] }}</span>
        @if(isset($link['badge']) && $link['badge'] > 0)
        <span class="badge badge-sm badge-dark m-3">{{ $link['badge'] }}</span>
        @endif
      </a>
    </li>
    @endforeach
  </ul>
</div>