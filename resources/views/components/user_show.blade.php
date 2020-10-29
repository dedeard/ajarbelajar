@php
$links = [
    [
      'name' => 'Aktifitas',
      'route' => 'users.show',
      'badge' => '',
    ],
    [
      'name' => 'Edit',
      'route' => 'users.edit',
      'badge' => '',
    ],
    [
      'name' => 'Favorit',
      'route' => 'users.show.favorites',
      'badge' => count($user->favorites),
    ],
    [
      'name' => 'Diikuti',
      'route' => 'users.show.followings',
      'badge' => count($user->followings),
    ],
];
@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <div class="card card-shadow">
        <div class="card-header bg-white text-center p-30 pb-15">
          <span class="avatar avatar-100 img-bordered mb-10 bg-primary">
            <img src="{{ $user->avatar_url }}">
          </span>
          <div class="font-size-20 dark">{{ $user->name }}</div>
          <span class="badge badge-primary">{{ $user->points }} point</span>
          <div class="grey-400 font-size-14 mb-20">{{ $user->username }}</div>
          @if(empty($user->minitutor))
          <a href="{{ route('users.minitutor.create', $user->id) }}" class="btn btn-sm btn-primary">Buat MiniTutor</a>
          @else
          <a href="{{ route('minitutors.show', $user->minitutor->id) }}" class="btn btn-sm btn-primary">Lihat MiniTutor</a>
          @endif
          <div class="p-3">
            @if($user->website_url)
              <a target="_blank" href="{{ $user->website_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon wb-globe"></i></a>
            @endif
            @if($user->twitter_url)
              <a target="_blank" href="{{ $user->twitter_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-twitter"></i></a>
            @endif
            @if($user->facebook_url)
              <a target="_blank" href="{{ $user->facebook_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-facebook"></i></a>
            @endif
            @if($user->instagram_url)
            <a target="_blank" href="{{ $user->instagram_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-instagram"></i></a>
            @endif
            @if($user->youtube_url)
            <a target="_blank" href="{{ $user->youtube_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-youtube"></i></a>
            @endif
          </div>
          <p>{{ $user->about }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="panel nav-tabs-horizontal">
        <ul class="nav nav-tabs nav-tabs-line">
          @foreach ($links as $link)
            <li class="nav-item">
            <a class="nav-link @if(Route::is($link['route'])) active @endif" href="{{ route($link['route'], $user->id) }}">{{ $link['name'] }} <span class="badge badge-primary">{{ $link['badge'] }}</span></a>
            </li>
          @endforeach
        </ul>
        <div class="panel-body p-0">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</div>
