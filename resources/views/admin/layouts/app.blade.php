<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="current-url" content="{{ url()->current() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @auth
  <meta name="api-token" content="{{ Auth::user()->apiToken() }}">
  @endauth
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icons/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icons/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icons/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icons/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('icons/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('icons/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icons/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icons/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('icons/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icons/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="msapplication-TileColor" content="#677ae4">
  <meta name="msapplication-TileImage" content="{{ asset('icons/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#677ae4">
  <title>@yield('title') - Admin - ajarbelajar</title>

  
  <!-- Core -->
  <link rel="stylesheet" href="{{ asset('remark/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/css/bootstrap-extend.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/css/site.min.css') }}">

  
  <!-- Plugins -->
  <link rel="stylesheet" href="{{ asset('remark/vendor/animsition/animsition.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/asscrollable/asScrollable.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/switchery/switchery.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/intro-js/introjs.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/slidepanel/slidePanel.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/datatables.net-bs4/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/ladda/ladda.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/bootstrap-sweetalert/sweetalert.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/select2/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/vendor/dropify/dropify.min.css') }}">


  <!-- Fonts -->
  <link rel="stylesheet" href="{{ asset('remark/fonts/web-icons/web-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/fonts/brand-icons/brand-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('remark/fonts/font-awesome/font-awesome.min.css') }}">
  <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
  
  @yield('style')

  <!-- Scripts -->
  <script src="{{ asset('remark/vendor/breakpoints/breakpoints.min.js') }}"></script>
  <script>
    Breakpoints();
  </script>
</head>

<body class="animsition">

  <nav class="site-navbar navbar navbar-default navbar-fixed-top">
      <div class="navbar-header">
          <button type="button" class="navbar-toggler hamburger hamburger-close navbar-toggler-left hided"
              data-toggle="menubar">
              <span class="sr-only">Toggle navigation</span>
              <span class="hamburger-bar"></span>
          </button>
          <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-collapse"
              data-toggle="collapse">
              <i class="icon wb-more-horizontal" aria-hidden="true"></i>
          </button>
          <a class="navbar-brand navbar-brand-center" href="{{ route('home') }}">
              <img class="navbar-brand-logo" src="{{ asset('img/logo/logo-white.svg') }}" title="Logo ajarbelajar">
              <span class="navbar-brand-text hidden-xs-down"> Ajarbelajar</span>
          </a>
          <button type="button" class="navbar-toggler collapsed" data-target="#site-navbar-search" data-toggle="collapse">
              <span class="sr-only">Toggle Search</span>
              <i class="icon wb-search" aria-hidden="true"></i>
          </button>
      </div>

      <div class="navbar-container container-fluid">
          <!-- Navbar Collapse -->
          <div class="collapse navbar-collapse navbar-collapse-toolbar" id="site-navbar-collapse">
              <!-- Navbar Toolbar -->
              <ul class="nav navbar-toolbar">
                  <li class="nav-item hidden-float" id="toggleMenubar">
                      <a class="nav-link" data-toggle="menubar" href="#" role="button">
                          <i class="icon hamburger hamburger-arrow-left">
                              <span class="sr-only">Toggle menubar</span>
                              <span class="hamburger-bar"></span>
                          </i>
                      </a>
                  </li>
                  <li class="nav-item hidden-float">
                      <a class="nav-link icon wb-search" data-toggle="collapse" href="#" data-target="#site-navbar-search"
                          role="button">
                          <span class="sr-only">Toggle Search</span>
                      </a>
                  </li>
              </ul>
              <!-- End Navbar Toolbar -->

              <!-- Navbar Toolbar Right -->
              <ul class="nav navbar-toolbar navbar-right navbar-toolbar-right">
                  <li class="nav-item dropdown">
                      <a class="nav-link navbar-avatar" data-toggle="dropdown" href="#" aria-expanded="false"
                          data-animation="scale-up" role="button">
                          <span class="avatar avatar-online">
                              <img src="{{ Auth::user()->imageUrl() }}" alt="...">
                              <i></i>
                          </span>
                      </a>
                      <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-user"></i> Profile</a>
                          <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-settings"></i> Settings</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="javascript:void(0)" role="menuitem"><i class="icon wb-power"></i> Logout</a>
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Notifications"
                          aria-expanded="false" data-animation="scale-up" role="button">
                          <i class="icon wb-bell" aria-hidden="true"></i>
                          <span class="badge badge-pill badge-danger up">5</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                          <div class="dropdown-menu-header">
                              <h5>NOTIFICATIONS</h5>
                              <span class="badge badge-round badge-danger">New 5</span>
                          </div>
                          <div class="list-group">
                              <div data-role="container">
                                  <div data-role="content">
                                      <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <i class="icon wb-order bg-red-600 white icon-circle"
                                                      aria-hidden="true"></i>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">A new order has been placed</h6>
                                                  <time class="media-meta" datetime="2018-06-12T20:50:48+08:00">5 hours
                                                      ago</time>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <i class="icon wb-user bg-green-600 white icon-circle"
                                                      aria-hidden="true"></i>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Completed the task</h6>
                                                  <time class="media-meta" datetime="2018-06-11T18:29:20+08:00">2 days
                                                      ago</time>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <i class="icon wb-settings bg-red-600 white icon-circle"
                                                      aria-hidden="true"></i>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Settings updated</h6>
                                                  <time class="media-meta" datetime="2018-06-11T14:05:00+08:00">2 days
                                                      ago</time>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <i class="icon wb-calendar bg-blue-600 white icon-circle"
                                                      aria-hidden="true"></i>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Event started</h6>
                                                  <time class="media-meta" datetime="2018-06-10T13:50:18+08:00">3 days
                                                      ago</time>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <i class="icon wb-chat bg-orange-600 white icon-circle"
                                                      aria-hidden="true"></i>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Message received</h6>
                                                  <time class="media-meta" datetime="2018-06-10T12:34:48+08:00">3 days
                                                      ago</time>
                                              </div>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="dropdown-menu-footer">
                              <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                  <i class="icon wb-settings" aria-hidden="true"></i>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                  All notifications
                              </a>
                          </div>
                      </div>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)" title="Messages"
                          aria-expanded="false" data-animation="scale-up" role="button">
                          <i class="icon wb-envelope" aria-hidden="true"></i>
                          <span class="badge badge-pill badge-info up">3</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-media" role="menu">
                          <div class="dropdown-menu-header" role="presentation">
                              <h5>MESSAGES</h5>
                              <span class="badge badge-round badge-info">New 3</span>
                          </div>

                          <div class="list-group" role="presentation">
                              <div data-role="container">
                                  <div data-role="content">
                                      <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <span class="avatar avatar-sm avatar-online">
                                                      <img src="{{ Auth::user()->imageUrl() }}" alt="..." />
                                                      <i></i>
                                                  </span>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Mary Adams</h6>
                                                  <div class="media-meta">
                                                      <time datetime="2018-06-17T20:22:05+08:00">30 minutes ago</time>
                                                  </div>
                                                  <div class="media-detail">Anyways, i would like just do it</div>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <span class="avatar avatar-sm avatar-off">
                                                      <img src="{{ Auth::user()->imageUrl() }}" alt="..." />
                                                      <i></i>
                                                  </span>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Caleb Richards</h6>
                                                  <div class="media-meta">
                                                      <time datetime="2018-06-17T12:30:30+08:00">12 hours ago</time>
                                                  </div>
                                                  <div class="media-detail">I checheck the document. But there seems</div>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <span class="avatar avatar-sm avatar-busy">
                                                      <img src="{{ Auth::user()->imageUrl() }}" alt="..." />
                                                      <i></i>
                                                  </span>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">June Lane</h6>
                                                  <div class="media-meta">
                                                      <time datetime="2018-06-16T18:38:40+08:00">2 days ago</time>
                                                  </div>
                                                  <div class="media-detail">Lorem ipsum Id consectetur et minim</div>
                                              </div>
                                          </div>
                                      </a>
                                      <a class="list-group-item" href="javascript:void(0)" role="menuitem">
                                          <div class="media">
                                              <div class="pr-10">
                                                  <span class="avatar avatar-sm avatar-away">
                                                      <img src="{{ Auth::user()->imageUrl() }}" alt="..." />
                                                      <i></i>
                                                  </span>
                                              </div>
                                              <div class="media-body">
                                                  <h6 class="media-heading">Edward Fletcher</h6>
                                                  <div class="media-meta">
                                                      <time datetime="2018-06-15T20:34:48+08:00">3 days ago</time>
                                                  </div>
                                                  <div class="media-detail">Dolor et irure cupidatat commodo nostrud
                                                      nostrud.</div>
                                              </div>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                          </div>
                          <div class="dropdown-menu-footer" role="presentation">
                              <a class="dropdown-menu-footer-btn" href="javascript:void(0)" role="button">
                                  <i class="icon wb-settings" aria-hidden="true"></i>
                              </a>
                              <a class="dropdown-item" href="javascript:void(0)" role="menuitem">
                                  See all messages
                              </a>
                          </div>
                      </div>
                  </li>
                  <li class="nav-item" id="toggleChat">
                      <a class="nav-link" data-toggle="site-sidebar" href="javascript:void(0)" title="Chat"
                          data-url="../site-sidebar.tpl">
                          <i class="icon wb-chat" aria-hidden="true"></i>
                      </a>
                  </li>
              </ul>
              <!-- End Navbar Toolbar Right -->
          </div>
          <!-- End Navbar Collapse -->

          <!-- Site Navbar Seach -->
          <div class="collapse navbar-search-overlap" id="site-navbar-search">
              <form role="search">
                  <div class="form-group">
                      <div class="input-search">
                          <i class="input-search-icon wb-search" aria-hidden="true"></i>
                          <input type="text" class="form-control" name="site-search" placeholder="Search...">
                          <button type="button" class="input-search-close icon wb-close" data-target="#site-navbar-search"
                              data-toggle="collapse" aria-label="Close"></button>
                      </div>
                  </div>
              </form>
          </div>
          <!-- End Site Navbar Seach -->
      </div>
  </nav>
  <div class="site-menubar">
      <div class="site-menubar-body">
        <div>
          <div>
            <ul class="site-menu" data-plugin="menu">
              <li class="site-menu-category"></li>

              <li class="site-menu-item @if(Route::is('admin.dashboard*')) active @endif">
                <a href="{{ route('admin.dashboard') }}">
                  <i class="site-menu-icon wb-dashboard"></i>
                  <span class="site-menu-title">Dashboard</span>
                </a>
              </li>

              @can('manage seo')
              <li class="site-menu-item @if(Route::is('admin.seo*')) active @endif">
                <a href="{{ route('admin.seo.index') }}">
                  <i class="site-menu-icon wb-globe"></i>
                  <span class="site-menu-title">Seo</span>
                </a>
              </li>
              @endcan

              <li class="site-menu-item @if(Route::is('admin.comment*')) active @endif">
                <a href="{{ route('admin.comment.index') }}">
                  <i class="site-menu-icon wb-chat"></i>
                  <span class="site-menu-title">Komentar</span>
                </a>
              </li>

              @can('manage category')
              <li class="site-menu-item @if(Route::is('admin.categories*')) active @endif">
                <a href="{{ route('admin.categories.index') }}">
                  <i class="site-menu-icon wb-list"></i>
                  <span class="site-menu-title">Categories</span>
                </a>
              </li>
              @endcan

              @can('manage user')
              <li class="site-menu-item @if(Route::is('admin.users*')) active @endif">
                <a href="{{ route('admin.users.index') }}">
                  <i class="site-menu-icon wb-users"></i>
                  <span class="site-menu-title">Users</span>
                </a>
              </li>
              @endcan

              @can('manage minitutor')
              <li class="site-menu-item has-sub @if(Route::is('admin.minitutor*')) active open @endif">
                <a href="javascript:;">
                  <i class="site-menu-icon wb-user-circle"></i>
                  <span class="site-menu-title">MiniTutor</span>
                  <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item @if(Route::is('admin.minitutor.index')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.minitutor.index') }}">
                      <span class="site-menu-title">Daftar MiniTutor</span>
                    </a>
                  </li>
                  <li class="site-menu-item @if(Route::is('admin.minitutor.request*')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.minitutor.request.index') }}">
                      <span class="site-menu-title">Permintaan</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan


              @can('manage post')
              <li class="site-menu-item has-sub @if(Route::is('admin.articles*')) active open @endif">
                <a href="javascript:;">
                  <i class="site-menu-icon wb-order"></i>
                  <span class="site-menu-title">Artikel</span>
                  <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item @if(Route::is('admin.articles.index')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.articles.index') }}">
                      <span class="site-menu-title">Daftar Artikel</span>
                    </a>
                  </li>
                  <li class="site-menu-item @if(Route::is('admin.articles.requested*')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.articles.requested') }}">
                      <span class="site-menu-title">Permintaan</span>
                    </a>
                  </li>
                  <li class="site-menu-item @if(Route::is('admin.articles.create*')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.articles.create.index') }}">
                      <span class="site-menu-title">Buat Artikel</span>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="site-menu-item has-sub @if(Route::is('admin.videos*')) active open @endif">
                <a href="javascript:;">
                  <i class="site-menu-icon wb-video"></i>
                  <span class="site-menu-title">Video</span>
                  <span class="site-menu-arrow"></span>
                </a>
                <ul class="site-menu-sub">
                  <li class="site-menu-item @if(Route::is('admin.videos.index')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.videos.index') }}">
                      <span class="site-menu-title">Daftar Video</span>
                    </a>
                  </li>
                  <li class="site-menu-item @if(Route::is('admin.videos.requested*')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.videos.requested') }}">
                      <span class="site-menu-title">Permintaan</span>
                    </a>
                  </li>
                  <li class="site-menu-item @if(Route::is('admin.videos.create*')) active @endif">
                    <a class="animsition-link" href="{{ route('admin.videos.create.index') }}">
                      <span class="site-menu-title">Buat Video</span>
                    </a>
                  </li>
                </ul>
              </li>
              @endcan

            </ul>
          </div>
        </div>
      </div>

      <div class="site-menubar-footer">
          <a href="javascript: void(0);" class="fold-show" data-placement="top" data-toggle="tooltip"
              data-original-title="Settings">
              <span class="icon wb-settings" aria-hidden="true"></span>
          </a>
          <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Lock">
              <span class="icon wb-eye-close" aria-hidden="true"></span>
          </a>
          <a href="javascript: void(0);" data-placement="top" data-toggle="tooltip" data-original-title="Logout">
              <span class="icon wb-power" aria-hidden="true"></span>
          </a>
      </div>
  </div>

  <!-- Page -->
  <div class="page">
    <div class="page-content">
      
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-alt dark alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          {{ $message }}
        </div>
      @endif
      @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-alt dark alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          {{ $message }}
        </div>
      @endif
      @if ($message = Session::get('warning'))
        <div class="alert alert-warning alert-alt dark alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          {{ $message }}
        </div>
      @endif
      @if ($message = Session::get('info'))
        <div class="alert alert-info alert-alt dark alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          {{ $message }}
        </div>
      @endif

      @yield('content')
    </div>
  </div>
  <!-- Footer -->
  <footer class="site-footer">
    <div class="site-footer-legal">© 2018 <a href="#">Remark</a></div>
    <div class="site-footer-right">
      Crafted with <i class="red-600 wb wb-heart"></i> by <a href="#">Creation Studio</a>
    </div>
  </footer>

  <!-- Core  -->
  <script src="{{ asset('remark/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
  <script src="{{ asset('remark/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/popper-js/umd/popper.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/animsition/animsition.min.js') }}"></script> 
  <script src="{{ asset('remark/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
  <script src="{{ asset('remark/vendor/asscrollbar/jquery-asScrollbar.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/asscrollable/jquery-asScrollable.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/ashoverscroll/jquery-asHoverScroll.min.js') }}"></script>
  
  <!-- Plugins -->
  <script src="{{ asset('remark/vendor/switchery/switchery.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/intro-js/intro.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/slidepanel/jquery-slidePanel.min.js') }}"></script>
  
  <script src="{{ asset('remark/vendor/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('remark/vendor/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('remark/vendor/ladda/spin.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/ladda/ladda.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/bootstrap-sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/dropify/dropify.min.js') }}"></script>
  <script src="{{ asset('remark/vendor/select2/select2.full.min.js') }}"></script>

  <!-- Scripts -->
  <script src="{{ asset('remark/js/Component.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin.js') }}"></script>
  <script src="{{ asset('remark/js/Base.js') }}"></script>
  <script src="{{ asset('remark/js/Config.js') }}"></script>
  
  <script src="{{ asset('remark/js/Section/Menubar.js') }}"></script>
  <script src="{{ asset('remark/js/Section/GridMenu.js') }}"></script>
  <script src="{{ asset('remark/js/Section/Sidebar.js') }}"></script>
  <script src="{{ asset('remark/js/Section/PageAside.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/menu.js') }}"></script>
  
  <script src="{{ asset('remark/js/config/colors.js') }}"></script>
  <script src="{{ asset('remark/js/config/tour.js') }}"></script>
  <script>Config.set('assets', "{{ asset('remark') }}");</script>
  
  <!-- Page -->
  <script src="{{ asset('remark/js/Site.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/asscrollable.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/slidepanel.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/switchery.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/ladda.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/dropify.js') }}"></script>
  <script src="{{ asset('remark/js/Plugin/select2.js') }}"></script>

  
  <script>
    (function(document, window, $){
      'use strict';
  
      var Site = window.Site;
      $(document).ready(function(){
        Site.run();
      });
    })(document, window, jQuery);
  </script>


  <script src="{{ asset('js/admin.js') }}"></script>
  @yield('script')
</body>

</html>