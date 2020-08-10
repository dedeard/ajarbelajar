@php
$linkGroups = [
  [
    [
      'name' => 'Dashboard',
      'route' => 'admin.dashboard',
      'is' => 'admin.dashboard',
      'icon' => 'wb-dashboard'
    ]
  ],
  [
    [
      'name' => 'Permission',
      'route' => 'admin.permissions.index',
      'is' => 'admin.permissions*',
      'icon' => 'wb-lock'
    ],
    [
      'name' => 'Role',
      'route' => 'admin.roles.index',
      'is' => 'admin.roles*',
      'icon' => 'wb-lock'
    ]
  ]
];
@endphp

<section class="page-aside-section">
  @foreach($linkGroups as $linkGroup)
    <div class="list-group">
      @foreach($linkGroup as $l)
        <a class="list-group-item @if(Route::is($l['is'])) active @endif" href="{{ route($l['route']) }}">
          <i class="icon {{ $l['icon'] }}"></i>
          {{ $l['name'] }}
        </a>
      @endforeach
    </div>
  @endforeach
</section>
