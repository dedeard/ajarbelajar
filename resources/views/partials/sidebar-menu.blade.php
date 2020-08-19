@php
$linkGroups = [
  [
    [
      'name' => 'Role',
      'route' => 'roles.index',
      'is' => 'roles*',
      'icon' => 'wb-lock',
      'can' => 'manage role',
    ]
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
