@php
$links = [
    [
      'name' => 'Info',
      'route' => 'minitutors.show',
      'badge' => '',
    ],
    [
      'name' => 'Edit',
      'route' => 'minitutors.edit',
      'badge' => '',
    ],
    [
      'name' => 'Artikel',
      'route' => 'minitutors.show.articles',
      'badge' => $minitutor->articles()->count(),
    ],
    [
      'name' => 'Playlist',
      'route' => 'minitutors.show.playlists',
      'badge' => $minitutor->playlists()->count(),
    ],
    [
      'name' => 'Pengikut',
      'route' => 'minitutors.show.followers',
      'badge' => $minitutor->subscribers()->count(),
    ],
    [
      'name' => 'Feedback',
      'route' => 'minitutors.show.feedback',
      'badge' => count($minitutor->feedback),
    ],
    [
      'name' => 'Komentar',
      'route' => 'minitutors.show.comments',
      'badge' => count($minitutor->comments),
    ],
];
@endphp
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">
      <div class="card card-shadow">
        <div class="card-header bg-white text-center p-30 pb-15">
          <span class="avatar avatar-100 img-bordered mb-10 bg-primary">
            <img src="{{ $minitutor->user->avatar_url }}">
          </span>
          <div class="font-size-20 dark">{{ $minitutor->user->name }}</div>
          <span class="badge badge-primary">{{ $minitutor->user->points }} point</span>
          <div class="grey-400 font-size-14 mb-20">{{ $minitutor->user->username }}</div>
          <a class="btn btn-sm btn-danger" href="{{ route('minitutors.active.toggle', $minitutor->id) }}">
            @if($minitutor->active)
            Nonaktifkan
            @else
            Aktifkan
            @endif
          </a>
          <div class="p-3">
            @if($minitutor->user->website_url)
              <a target="_blank" href="{{ $minitutor->user->website_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon wb-globe"></i></a>
            @endif
            @if($minitutor->user->twitter_url)
              <a target="_blank" href="{{ $minitutor->user->twitter_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-twitter"></i></a>
            @endif
            @if($minitutor->user->facebook_url)
              <a target="_blank" href="{{ $minitutor->user->facebook_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-facebook"></i></a>
            @endif
            @if($minitutor->user->instagram_url)
            <a target="_blank" href="{{ $minitutor->user->instagram_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-instagram"></i></a>
            @endif
            @if($minitutor->user->youtube_url)
            <a target="_blank" href="{{ $minitutor->user->youtube_url }}" class="btn btn-default btn-sm btn-icon btn-outline"><i class="icon socicon-youtube"></i></a>
            @endif
          </div>
          <p class="m-0">{{ $minitutor->user->about }}</p>
        </div>
        <div class="card-footer">
          @if($minitutor->active)
          <div class="mb-2 text-center">
            <a href="{{ route('playlists.create', ['id' => $minitutor->id]) }}" class="btn btn-sm btn-default">Buat Artikel</a>
            <a href="{{ route('articles.create', ['id' => $minitutor->id]) }}" class="btn btn-sm btn-default">Buat Playlist</a>
          </div>
          @endif
          <a href="{{ route('users.show', $minitutor->user->id) }}" class="btn btn-primary btn-block">LIHAT PROFIL PENGGUNA</a>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="panel nav-tabs-horizontal">
        <ul class="nav nav-tabs nav-tabs-line">
          @foreach ($links as $link)
            <li class="nav-item">
            <a class="nav-link @if(Route::is($link['route'])) active @endif" href="{{ route($link['route'], $minitutor->id) }}">{{ $link['name'] }} <span class="badge badge-primary">{{ $link['badge'] }}</span></a>
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
