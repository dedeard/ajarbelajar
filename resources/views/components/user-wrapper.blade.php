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
        'badge' => $user->favorites()->count(),
    ],
    [
        'name' => 'Diikuti',
        'route' => 'users.show.followings',
        'badge' => $user->followings()->count(),
    ],
];
@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">{{ $user->name }}</h3>
          <h5 class="widget-user-desc">{{ $user->username }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ $user->avatar_url }}">
        </div>
        <div class="card-footer">
          <div class="text-center mb-3">
            <span class="badge badge-primary">{{ $user->points }} point</span>
          </div>
          @if (empty($user->minitutor))
            <a href="{{ route('users.minitutor.create', $user->id) }}" class="btn btn-sm btn-primary btn-block">Buat MiniTutor</a>
          @else
            <a href="{{ route('minitutors.show', $user->minitutor->id) }}" class="btn btn-sm btn-primary btn-block">Lihat MiniTutor</a>
          @endif
          <p class="text-center">{{ $user->about }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            @foreach ($links as $link)
              <li class="nav-item">
                <a class="nav-link @if (Route::is($link['route'])) active @endif" href="{{ route($link['route'], $user->id) }}">{{ $link['name'] }}
                  <span class="badge badge-primary">{{ $link['badge'] }}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
        <div class="card-body p-0">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</div>
