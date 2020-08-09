<div class="app-header">
  <div class="app-header__wrapper">
    <div class="app-header__left">
      <div class="container-fluid">
        <div class="wrapper">
          <a href="{{ route('admin.dashboard') }}" class="brand">
            <span class="first">AB</span>
            <span class="last">ADMIN</span>
          </a>
        </div>
      </div>
    </div>
    <div class="app-header__right">
      <div class="container-fluid">
        <div class="wrapper">
          <div class="quick-actions">
            <ul class="nav">
              <li class="nav-item">
                <a class="active nav-link" href="javascript:;">New Video</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="javascript:;">Messages</a>
              </li>
            </ul>
          </div>
          <div class="user-actions">
            <a href="javascript:;" class="btn btn-action sidebar-toggle" v-open-sidebar>
              <i class="wb-grid-4"></i>
            </a>
            <a href="javascript:;" class="btn btn-action">
              <i class="wb-bell"></i>
              <span class="label">5</span>
            </a>
            <a href="javascript:;" class="avatar img-bordered bg-white"
              ><img
                src="https://www.ajarbelajar.com/img/placeholder/avatar.png"
                class="img-fluid"
            /></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
