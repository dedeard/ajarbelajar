<aside class="main-sidebar sidebar-dark-primary">
  <!-- Brand Logo -->
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <svg class="brand-image" style="width: 33px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 164.67 164.67">
      <path fill="currentColor"
        d="M164.67,82.34A82.32,82.32,0,0,0,40.8,11.26,21.75,21.75,0,0,0,0,21.76V82.34H0a82.32,82.32,0,0,0,123.87,71.08,21.74,21.74,0,0,0,19,11.25h0a21.75,21.75,0,0,0,21.75-21.75V82.34ZM82.33,121.18a38.83,38.83,0,1,1,38.83-38.83h0A38.83,38.83,0,0,1,82.33,121.18Z" />
    </svg>
    <span class="brand-text">ADMIN AB</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel d-flex mb-3 mt-3 pb-3">
      <div class="image">
        <img src="{{ Auth::user()->avatar_url }}" class="img-circle elevation-2" alt="{{ Auth::user()->name }}">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <x-admin::layouts.sidebar-menu />
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
