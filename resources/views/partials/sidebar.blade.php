<app-sidebar inline-template>
  <div class="app-sidebar">
    <div class="app-sidebar__backdrop" v-close-sidebar></div>
    <div class="app-sidebar__wrapper">
      <div class="app-sidebar__header">
        <div class="container-fluid">
          <div class="wrapper">
            <a href="#" class="brand">
              <span class="first">AB</span>
              <span class="last">ADMIN</span>
            </a>
            <a href="#" class="btn btn-sidebar" v-close-sidebar>
              <i class="wb-close"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="app-sidebar__scroll">
        <div class="app-sidebar__scroll-wrapper" ref="elSidebarScroll">
          <div class="app-sidebar__scroll-content">
            @include('partials.sidebar-menu')
          </div>
        </div>
      </div>
    </div>
  </div>
</app-sidebar>
