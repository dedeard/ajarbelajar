
<i id="ab-sidebar--toggle-size"></i>
<div class="ab-sidebar-backdrop" id="ab-sidebar-backdrop"></div>
<aside class="ab-sidebar" id="ab-sidebar">
  <div class="ab-sidebar__header">
    <div class="container-fluid">
      <div class="ab-sidebar__header-wrapper">
        <a href="/" class="ab-sidebar__brand">
          <img src="{{ asset('img/logo/logo-text.svg') }}" alt="Logo ajarbelajar" />
        </a>
        <a href="#" class="ab-sidebar__sidebar-toggle" data-toggle="sidebar">
          <i class="fa fa-bars icon"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="ab-sidebar__scroll">
    <div class="ab-sidebar__scroll-wrapper" id="ab-sidebar-scroll">
      <div class="ab-sidebar__scroll-content">
        <!-- <section class="page-aside-section">
          <div class="ab-sidebar__ads--wrapper px-40">
            <div class="p-15 text-center" style="border: 1px dashed #e6e6e6">
              <a href="#">
                <img src="https://cdn4.buysellads.net/uu/1/57095/1576856619-ad3.png" alt="ads via Carbon" style="width: 100%; display: block" />
              </a>
              <a href="#" class="font-size-10 text-danger d-block font-weight-light">
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
              </a>
            </div>
          </div>
        </section> -->
        <section class="page-aside-section">
          <div class="list-group">
            <a class="list-group-item @if(Route::is('home')) active @endif" href="{{ route('home') }}"><i class="icon wb-home"></i>Home</a>
            <a class="list-group-item @if(Route::is('article')) active @endif" href="{{ route('article') }}"><i class="icon wb-order"></i>Artikel</a>
            <a class="list-group-item @if(Route::is('video')) active @endif" href="{{ route('video') }}"><i class="icon wb-video"></i>Vidio</a>
            <a class="list-group-item @if(Route::is('category*')) active @endif" href="{{ route('category.index') }}"><i class="icon wb-grid-4"></i>Kategori</a>
            <a class="list-group-item @if(Route::is('minitutor*') && !Route::is('minitutor.join*')) active @endif" href="{{ route('minitutor.index') }}"><i class="icon wb-users"></i>Minitutor</a>
          </div>
        </section>
        <section class="page-aside-section">
          <div class="list-group">
            @if(!Auth::user())
              <a class="list-group-item @if(Route::is('minitutor.join*')) active @endif" href="{{ route('minitutor.join.index') }}">
                <i class="icon wb-dashboard"></i>
                Jadi Minitutor
              </a>
            @elseif(!Auth::user()->minitutor)
              <a class="list-group-item @if(Route::is('minitutor.join*')) active @endif" href="{{ route('minitutor.join.index') }}">
                <i class="icon wb-dashboard"></i>
                Jadi Minitutor
              </a>
            @endif
            @auth
            <a class="list-group-item @if(Route::is('dashboard*')) active @endif" href="{{ route('dashboard.index') }}">
              <i class="icon wb-user-circle"></i>
              Dasbor Kamu
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
</aside>