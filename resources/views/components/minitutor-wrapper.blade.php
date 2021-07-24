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
        'name' => 'Video',
        'route' => 'minitutors.show.videos',
        'badge' => $minitutor->videos()->count(),
    ],
    [
        'name' => 'Pengikut',
        'route' => 'minitutors.show.followers',
        'badge' => $minitutor->followers()->count(),
    ],
    [
        'name' => 'Feedback',
        'route' => 'minitutors.show.feedback',
        'badge' => $minitutor->feedback()->count(),
    ],
    [
        'name' => 'Komentar',
        'route' => 'minitutors.show.comments',
        'badge' => $minitutor->comments()->count(),
    ],
];
@endphp

<div class="container-fluid">
  <div class="row">
    <div class="col-md-3">

      <div class="card card-widget widget-user">
        <div class="widget-user-header bg-info">
          <h3 class="widget-user-username">{{ $minitutor->user->name }}</h3>
          <h5 class="widget-user-desc">{{ $minitutor->user->username }}</h5>
        </div>
        <div class="widget-user-image">
          <img class="img-circle elevation-2" src="{{ $minitutor->user->avatar_url }}">
        </div>
        <div class="card-footer">
          <div class="text-center mb-3">
            <span class="badge badge-primary">{{ $minitutor->user->points }} point</span>
          </div>
          <div class="text-center">
            <a class="btn btn-sm btn-danger" href="{{ route('minitutors.active.toggle', $minitutor->id) }}">
              @if ($minitutor->active)
                Nonaktifkan
              @else
                Aktifkan
              @endif
            </a>
          </div>
        </div>
        <div class="card-footer py-3">
          @if ($minitutor->active)
            <div class="mb-2 text-center">
              <a href="{{ route('videos.create', ['id' => $minitutor->id]) }}" class="btn btn-sm btn-default">Buat Video</a>
              <a href="{{ route('articles.create', ['id' => $minitutor->id]) }}" class="btn btn-sm btn-default">Buat Artikel</a>
            </div>
          @endif
          <a href="{{ route('users.show', $minitutor->user->id) }}" class="btn btn-primary btn-block btn-sm">Lihat Profile Pengguna</a>
        </div>
      </div>

    </div>
    <div class="col-md-9">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            @foreach ($links as $link)
              <li class="nav-item">
                <a class="nav-link @if (Route::is($link['route'])) active @endif"
                  href="{{ route($link['route'], $minitutor->id) }}">{{ $link['name'] }}
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
