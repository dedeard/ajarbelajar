<div class="minitutor-dashboard-layout">
  <div class="minitutor-dashboard-layout-side" sticky-container>
    <div class="container-fluid pr-lg-0">
      <div class="ab-profile-card-side" v-sticky sticky-offset="{ top: 60 }">
        <div class="avatar">
          <img src="{{ Auth::user()->imageUrl() }}" alt="{{ Auth::user()->username }}">
          <span class="point">{{ Auth::user()->minitutor->points }} Poin</span>
        </div>

        <div class="info">
          <a href="{{ route('minitutor.show', Auth::user()->username) }}" class="name">{{ Auth::user()->name() }}</a>
          <a href="{{ route('minitutor.show', Auth::user()->username) }}" class="username">{{ '@' . Auth::user()->username }}</a>
          <a href="{{ route('dashboard.me.edit.index') }}" class="btn btn-primary btn-sm btn-block">Edit Profile</a>
        </div>

        <div class="minitutor-menu">
          <div class="list-group">

            <?php
              $minitutorDashboardLinks = [
                [
                  'route' => 'dashboard.minitutor.edit.index',
                  'routeHas' => 'dashboard.minitutor.edit*',
                  'name' => 'Edit Informasi',
                  'icon' => 'wb-user-circle'
                ],
                [
                  'route' => 'dashboard.minitutor.accepted.index',
                  'routeHas' => 'dashboard.minitutor.accepted*',
                  'name' => 'Postingan Diterima',
                  'icon' => 'wb-check-circle',
                  'badge' => Auth::user()->posts()->count()
                ],
                [
                  'route' => 'dashboard.minitutor.articles.index',
                  'routeHas' => 'dashboard.minitutor.articles*',
                  'name' => 'Artikel',
                  'icon' => 'wb-list',
                  'badge' => Auth::user()->requestPosts()->where('type', 'article')->count()
                ],
                [
                  'route' => 'dashboard.minitutor.videos.index',
                  'routeHas' => 'dashboard.minitutor.videos*',
                  'name' => 'Video',
                  'icon' => 'wb-video',
                  'badge' => Auth::user()->requestPosts()->where('type', 'video')->count()
                ],
                [
                  'route' => 'dashboard.minitutor.comments.index',
                  'routeHas' => 'dashboard.minitutor.comments*',
                  'name' => 'Komentar',
                  'icon' => 'wb-chat-group',
                  'badge' => Auth::user()->postComments()->where('approved', 1)->count()
                ],
                [
                  'route' => 'dashboard.minitutor.reviews.index',
                  'routeHas' => 'dashboard.minitutor.reviews*',
                  'name' => 'Feedback konstruktif',
                  'icon' => 'wb-reply',
                  'badge' => Auth::user()->postReviews()->count()
                ],
                [
                  'route' => 'dashboard.minitutor.followers.index',
                  'routeHas' => 'dashboard.minitutor.followers*',
                  'name' => 'Pengikut',
                  'icon' => 'wb-users',
                  'badge' => Auth::user()->minitutor->subscribers()->count()
                ],
              ];
            ?>
            @foreach($minitutorDashboardLinks as $data)
              <a class="list-group-item {{ Route::is($data['routeHas']) ? 'active' : '' }}" href="{{ route($data['route']) }}">
                <i class="icon {{ $data['icon'] }}"></i>{{ $data['name'] }}
                @if(isset($data['badge']) && $data['badge'] > 0)
                <span class="badge">{{ $data['badge'] }}</span>
                @endif
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
    <div class="minitutor-dashboard-layout-content">
      {{ $slot }}
  </div>
</div>