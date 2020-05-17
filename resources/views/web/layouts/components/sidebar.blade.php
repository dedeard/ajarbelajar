
<i id="ab-sidebar--toggle-size"></i>
<div class="ab-sidebar-backdrop" v-sidebar-backdrop></div>
<aside class="ab-sidebar" id="ab-sidebar">
  <div class="ab-sidebar__header">
    <div class="container-fluid">
      <div class="ab-sidebar__header-wrapper">
        <a href="/" class="ab-sidebar__brand">
          <img src="{{ asset('img/logo/logo-text-v2.svg') }}" alt="Logo ajarbelajar" />
        </a>
        <a href="#" class="ab-sidebar__sidebar-toggle" v-sidebar-toggle>
          <i class="wb-menu icon"></i>
        </a>
      </div>
    </div>
  </div>
  <sidebar-scroll inline-template>
    <div class="ab-sidebar__scroll">
      <div class="ab-sidebar__scroll-wrapper" ref="elSidebarScroll">
        <div class="ab-sidebar__scroll-content">
          <section class="page-aside-section">
            <div class="list-group">
              <a class="list-group-item @if(Route::is('home')) active @endif" href="{{ route('home') }}"><i class="icon wb-home"></i>Home</a>
              <a class="list-group-item @if(Route::is('about')) active @endif" href="{{ route('about') }}"><i class="icon wb-info"></i>Tentang AjarBelajar</a>
              <a class="list-group-item @if(Route::is('article')) active @endif" href="{{ route('article') }}"><i class="icon wb-order"></i>Artikel</a>
              <a class="list-group-item @if(Route::is('video')) active @endif" href="{{ route('video') }}"><i class="icon wb-video"></i>Video</a>
              <a class="list-group-item @if(Route::is('category*')) active @endif" href="{{ route('category.index') }}"><i class="icon wb-grid-4"></i>Kategori</a>
              <a class="list-group-item @if(Route::is('minitutor*')) active @endif" href="{{ route('minitutor.index') }}"><i class="icon wb-users"></i>Minitutor</a>
            </div>
          </section>
          <section class="page-aside-section">
            <div class="list-group">
              @if(!Auth::user())
                <a class="list-group-item @if(Route::is('join.minitutor*')) active @endif" href="{{ route('join.minitutor.index') }}">
                  <i class="icon wb-dashboard"></i>
                  Jadi Minitutor
                </a>
              @elseif(!Auth::user()->minitutor)
                <a class="list-group-item @if(Route::is('join.minitutor*')) active @endif" href="{{ route('join.minitutor.index') }}">
                  <i class="icon wb-dashboard"></i>
                  Jadi Minitutor
                </a>
              @endif
              @auth
              <a class="list-group-item @if(Route::is('dashboard.me*')) active @endif" href="{{ route('dashboard.me.index') }}">
                <i class="icon wb-user-circle"></i>
                Dasbor Kamu
              </a>
              @if(Auth::user() && Auth::user()->minitutor && Auth::user()->minitutor->active)
                <a class="list-group-item @if(Route::is('dashboard.minitutor*')) active @endif" href="{{ route('dashboard.minitutor.index') }}">
                  <i class="icon wb-dashboard"></i>
                  Dasbor MiniTutor
                </a>
              @endif
              @role('Super Admin|Administrator|Moderator')
                <a class="list-group-item" href="{{ route('admin.dashboard') }}">
                  <i class="icon wb-lock"></i>
                  Dasbor Admin
                </a>
              @endrole
              <a href="{{ route('logout') }}" class="list-group-item" onclick="event.preventDefault(); document.getElementById('form-logout-sidebar').submit();">
                <i class="icon wb-power"></i>
                Keluar
                <form action="{{ route('logout') }}" class="d-none" method="post" id="form-logout-sidebar">@csrf </form>
              </a>
              @else
              <a class="list-group-item" href="{{ route('register') }}">
                <i class="icon wb-user-circle"></i>
                Daftar
              </a>
              <a class="list-group-item" href="{{ route('login') }}">
                <i class="icon wb-user-circle"></i>
                Masuk
              </a>
              @endauth
            </div>
          </section>
        </div>
      </div>
    </div>
  </sidebar-scroll>
</aside>