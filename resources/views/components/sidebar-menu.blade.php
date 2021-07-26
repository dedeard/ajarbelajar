@php
$menu = [
    [
        [
            'name' => 'Dashboard',
            'route' => 'dashboard',
            'is' => 'dashboard',
            'icon' => 'tachometer-alt',
        ],
        [
            'name' => 'User',
            'route' => 'users.index',
            'is' => 'users*',
            'icon' => 'users',
            'can' => 'manage user',
        ],
        [
            'name' => 'MiniTutor',
            'route' => 'minitutors.index',
            'is' => 'minitutors*',
            'icon' => 'user-circle',
            'can' => 'manage minitutor',
        ],
    ],
    [
        [
            'name' => 'Komentar',
            'route' => 'comments.index',
            'is' => 'comments*',
            'icon' => 'comments',
            'can' => 'manage comment',
        ],
    ],
    [
        [
            'name' => 'Artikel',
            'route' => 'articles.index',
            'is' => 'articles*',
            'icon' => 'newspaper',
            'can' => 'manage article',
        ],
        [
            'name' => 'Video',
            'route' => 'videos.index',
            'is' => 'videos*',
            'icon' => 'video',
            'can' => 'manage video',
        ],
        [
            'name' => 'Artikel Permintaan',
            'route' => 'request-articles.index',
            'is' => 'request-articles*',
            'icon' => 'newspaper',
            'can' => 'manage article',
        ],
        [
            'name' => 'Video Permintaan',
            'route' => 'request-videos.index',
            'is' => 'request-videos*',
            'icon' => 'video',
            'can' => 'manage video',
        ],
    ],
    [
        [
            'name' => 'Role',
            'route' => 'roles.index',
            'is' => 'roles*',
            'icon' => 'lock',
            'can' => 'manage role',
        ],
        [
            'name' => 'Permission',
            'route' => 'permissions.index',
            'is' => 'permissions*',
            'icon' => 'lock',
            'can' => 'manage permission',
        ],
    ],
];
$x = true;
@endphp

@foreach ($menu as $group)
  @if ($x)
    @php
      $x = false;
    @endphp
  @else
    <li class="py-3"></li>
  @endif
  @foreach ($group as $link)
    @if (isset($l['can']))
      @can($link['can'])
        <li class="nav-item">
          <a href="{{ route($link['route']) }}" class="nav-link @if (Route::is($link['is'])) active @endif">
            <i class="nav-icon fas fa-{{ $link['icon'] }}"></i>
            <p>
              {{ $link['name'] }}
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
      @endcan
    @else
      <li class="nav-item">
        <a href="{{ route($link['route']) }}" class="nav-link @if (Route::is($link['is'])) active @endif">
          <i class="nav-icon fas fa-{{ $link['icon'] }}"></i>
          <p>
            {{ $link['name'] }}
            {{-- <span class="right badge badge-danger">New</span> --}}
          </p>
        </a>
      </li>
    @endif
  @endforeach
@endforeach
