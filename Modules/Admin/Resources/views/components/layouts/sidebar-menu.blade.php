@php
  $menu = [
      [
          [
              'name' => config('app.name', 'Laravel'),
              'route' => 'home',
              'is' => 'home',
              'icon' => 'globe',
          ],
      ],
      [
          [
              'name' => 'Dashboard',
              'route' => 'admin.dashboard',
              'is' => 'admin.dashboard',
              'icon' => 'tachometer-alt',
          ],
      ],
      [
          [
              'name' => 'Peran',
              'route' => 'admin.roles.index',
              'is' => 'admin.roles*',
              'icon' => 'lock',
              'can' => 'read role',
          ],
          [
              'name' => 'Admin',
              'route' => 'admin.admins.index',
              'is' => 'admin.admins*',
              'icon' => 'user',
              'can' => 'read admin',
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
    @if (isset($link['can']))
      @can($link['can'])
        <li class="nav-item">
          <a href="{{ route($link['route']) }}"
            class="nav-link @if (Route::is($link['is'])) active @endif">
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
        <a href="{{ route($link['route']) }}"
          class="nav-link @if (Route::is($link['is'])) active @endif">
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
