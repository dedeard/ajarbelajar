@php
$linkGroups = [
  [
    [
      'name' => 'Kategori',
      'route' => 'categories.index',
      'is' => 'categories*',
      'icon' => 'wb-list',
      'can' => 'manage category'
    ],
    [
      'name' => 'User',
      'route' => 'users.index',
      'is' => 'users*',
      'icon' => 'wb-users',
      'can' => 'manage user',
    ],
    [
      'name' => 'MiniTutor',
      'route' => 'minitutors.index',
      'is' => 'minitutors*',
      'icon' => 'wb-user-circle',
      'can' => 'manage minitutor',
    ],
    [
      'name' => 'Artikel',
      'route' => 'articles.index',
      'is' => 'articles*',
      'icon' => 'wb-order',
      'can' => 'manage article',
    ],
    [
      'name' => 'Playlist Permintaan',
      'route' => 'request-playlists.index',
      'is' => 'request-playlists*',
      'icon' => 'wb-video',
      'can' => 'manage playlist',
    ],
    [
      'name' => 'Playlist',
      'route' => 'playlists.index',
      'is' => 'playlists*',
      'icon' => 'wb-video',
      'can' => 'manage playlist',
    ]
  ],
  [
    [
      'name' => 'Role',
      'route' => 'roles.index',
      'is' => 'roles*',
      'icon' => 'wb-lock',
      'can' => 'manage role',
    ],
    [
      'name' => 'Permission',
      'route' => 'permissions.index',
      'is' => 'permissions*',
      'icon' => 'wb-lock',
      'can' => 'manage permission',
    ],
  ]
];
@endphp

<section class="page-aside-section">
  @foreach($linkGroups as $linkGroup)
    <div class="list-group">
      @foreach($linkGroup as $l)
        @can($l['can'])
          <a class="list-group-item @if(Route::is($l['is'])) active @endif" href="{{ route($l['route']) }}">
            <i class="icon {{ $l['icon'] }}"></i>
            {{ $l['name'] }}
          </a>
        @endcan
      @endforeach
    </div>
  @endforeach
</section>
