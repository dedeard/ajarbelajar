@php
$linkGroups = [];
@endphp

<section class="page-aside-section">
  @foreach($linkGroups as $linkGroup)
    <div class="list-group">
      @foreach($linkGroup as $l)
        @can($i['can'])
          <a class="list-group-item @if(Route::is($l['is'])) active @endif" href="{{ route($l['route']) }}">
            <i class="icon {{ $l['icon'] }}"></i>
            {{ $l['name'] }}
          </a>
        @endcan
      @endforeach
    </div>
  @endforeach
</section>
