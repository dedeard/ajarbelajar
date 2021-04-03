@php
$linkGroups = [
  [
    [
      'name' => 'Dashboard',
      'route' => 'dashboard',
      'is' => 'dashboard',
      'icon' => 'wb-globe',
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
      'name' => 'Email',
      'route' => 'emails.index',
      'is' => 'emails*',
      'icon' => 'wb-envelope',
      'can' => 'manage email',
    ],
  ],
  [
    [
      'name' => 'SEO',
      'route' => 'seos.index',
      'is' => 'seos*',
      'icon' => 'wb-globe',
      'can' => 'manage seo',
    ],
    [
      'name' => 'Kategori',
      'route' => 'categories.index',
      'is' => 'categories*',
      'icon' => 'wb-list',
      'can' => 'manage category'
    ],
    [
      'name' => 'Komentar',
      'route' => 'comments.index',
      'is' => 'comments*',
      'icon' => 'wb-chat',
      'can' => 'manage comment',
    ],
  ],
  [
    [
      'name' => 'Halaman',
      'route' => 'pages.index',
      'is' => 'pages*',
      'icon' => 'wb-layout',
      'can' => 'manage page'
    ],
    [
      'name' => 'Artikel',
      'route' => 'articles.index',
      'is' => 'articles*',
      'icon' => 'wb-order',
      'can' => 'manage article',
    ],
    [
      'name' => 'Playlist',
      'route' => 'playlists.index',
      'is' => 'playlists*',
      'icon' => 'wb-video',
      'can' => 'manage playlist',
    ],
    [
      'name' => 'Artikel Permintaan',
      'route' => 'request-articles.index',
      'is' => 'request-articles*',
      'icon' => 'wb-order',
      'can' => 'manage article',
    ],
    [
      'name' => 'Playlist Permintaan',
      'route' => 'request-playlists.index',
      'is' => 'request-playlists*',
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
  ],
  [
    [
      'name' => 'Profile',
      'route' => 'profile.index',
      'is' => 'profile*',
      'icon' => 'wb-user',
    ],
    [
      'name' => 'Logout',
      'route' => 'profile.logout',
      'is' => 'profile*',
      'icon' => 'wb-power text-danger',
    ],
  ],
];
@endphp

<section class="page-aside-section">
  @foreach($linkGroups as $linkGroup)
    <div class="list-group">
      @foreach($linkGroup as $l)
        @if(isset($l['can']))
          @can($l['can'])
          <a class="list-group-item @if(Route::is($l['is'])) active @endif" href="{{ route($l['route']) }}">
            <i class="icon {{ $l['icon'] }}"></i>
            {{ $l['name'] }}
          </a>
          @endcan
        @else
        <a class="list-group-item @if(Route::is($l['is'])) active @endif" href="{{ route($l['route']) }}">
          <i class="icon {{ $l['icon'] }}"></i>
          {{ $l['name'] }}
        </a>
        @endif
      @endforeach
    </div>
  @endforeach
</section>
