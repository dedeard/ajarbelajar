<div class="ab-header">
  <div class="ab-header__wrapper">
    <div class="ab-header__left">
      <div class="container-fluid">
        <div class="ab-header__left-wrapper">
          <a href="/" class="ab-header__brand">
            <img src="{{ asset('img/logo/logo-text.svg') }}" alt="Logo ajarbelajar" class="d-none d-lg-block" />
            <img src="{{ asset('img/logo/logo.svg') }}" alt="Logo ajarbelajar" class="d-block d-lg-none" />
          </a>
          <a href="#" class="ab-header__sidebar-toggle ml-lg-auto ml-10" data-toggle="sidebar">
            <i class="wb-menu icon"></i>
          </a>
          <a href="#" class="ab-header__sidebar-toggle d-block d-lg-none" data-toggle="header-form-search">
            <i class="wb-search icon"></i>
          </a>
        </div>
      </div>
    </div>
    <form action="{{ route('home') }}" class="ab-header__form-search" id="header-form-search" method="GET">
      <div class="container-fluid">
        <div class="ab-header__form-search-wrapper">
          <input class="form-control ab-header__form-search-input" type="search" name="search" value="{{ request()->input('search') }}" placeholder="Apa yang anda cari?">
          <button class="btn ab-header__form-search-toggle">
            <i class="wb-search"></i>
          </button>
        </div>
      </div>
    </form>
    <div class="ab-header__right ml-auto">
      <div class="container-fluid">
        <div class="ab-header__right-wrapper">
          @auth
          <div class="ab-header__right-actions">
            <!-- <a href="javascript:;" class="ab-header__right-action">
              <i class="fa fa-envelope"></i>
            </a> -->
            <a href="{{ route('notifications.index') }}" class="ab-header__right-action ab-notification-dropdown-toggle">
              <i class="wb-bell"></i>
              <span class="ab-header__right-action-label" notification-count></span>
            </a>
          </div>
          <div class="ab-header__right-avatar">
            <a class="avatar avatar-online img-bordered bg-white" href="javascript:;">
              <i></i>
              <img class="img-fluid" src="{{ Auth::user()->imageUrl() }}" alt="...">
            </a>
            <div class="ab-profile-dropdown">
              <span class="caret"></span>
              <div class="ab-profile-dropdown__wrapper">
                <div class="card m-0">
                  <div class="card-header card-header-transparent py-30 text-center">
                    <a class="avatar avatar-100 bg-white mb-10 m-xs-0 img-bordered" href="javascript:;">
                      <img src="{{ Auth::user()->imageUrl() }}" alt="">
                    </a>
                    <div class="font-size-20 text-capitalize">{{ Auth::user()->name()  }}</div>
                    <div class="font-size-14 grey-400 text-lowercase">{{ '@' . Auth::user()->username }}</div>
                  </div>
                  <div class="card-body">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-inverse btn-block">Dashboard</a>
                    <a href="{{ route('dashboard.edit') }}" class="btn btn-inverse btn-block">Edit profile</a>
                  </div>
                  <div class="card-footer card-footer-transparent">
                    <a href="{{ route('logout') }}" class="btn btn-wide btn-sm btn-danger" onclick="event.preventDefault(); $('#form-logout').submit();">Keluar</a>
                    <form action="{{ route('logout') }}" method="post" id="form-logout">@csrf </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @else
          <div class="ab-header__right-auth-buttons">
            <a href="{{ route('login') }}" class="ab-header__right-auth-button-signin btn btn-outline btn-default mr-10">Masuk</a>
            <a href="{{ route('register') }}" class="ab-header__right-auth-button-signinup btn btn-primary">Daftar</a>
          </div>
          @endauth
        </div>
      </div>
    </div>
  </div>
</div>