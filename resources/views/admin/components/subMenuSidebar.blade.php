<li class="kt-menu__item {{ Route::is($route) ? 'kt-menu__item--active' : '' }}">
  <a href="{{ route($route) }}" class="kt-menu__link ">
    <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>
    <span class="kt-menu__link-text">{{ $text }}</span>
  </a>
</li>