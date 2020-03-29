<script>
window.SIDEBAR_CLOSE = true
</script>

<div class="container-fluid mt-15 ">
  <div class="card card-inverse card-shadow cover white">
    <div class="cover-background" style="background-image: url({{asset('img/background/snow.jpg')}})">
      <div class="card-block p-30 overlay-background ">
        <a class="avatar avatar-100 img-bordered bg-white float-left mr-20" href="javascript:void(0)">
          <img src="{{ Auth::user()->imageUrl() }}" alt="">
        </a>
        <div class="vertical-align h-100 text-truncate">
          <div class="vertical-align-middle">
            <div class="font-size-20 mb-5 text-truncate text-capitalize">{{ Auth::user()->name() }}</div>
            <div class="font-size-14 text-truncate">{{ '@' . Auth::user()->username }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
  @if(Auth::user()->email_verified_at === null)
  <div class="alert alert-warning text-center">
    Alamat Email Anda belum di Verifikasi. silahkan cek email anda kemudian klik link Verifikasinya, <br>
    Jika anda belum menerima email Verifikasinya silahkan klik <a href="{{ route('verification.notice') }}" class="">Disini</a>
  </div>
  @endif
  <ul class="ab-dashboard__nav-quick nav-quick nav-quick-sm row">

    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.edit') ? 'active' : '' }}" href="{{ route('dashboard.edit') }}">
        <i class="icon wb-user-circle"></i>
        <span class="d-lg-block d-none">Edit Profile</span>
      </a>
    </li>
    <!-- <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.edit') ? 'active' : '' }}" href="{{ route('dashboard.edit') }}">
        <i class="icon wb-chat-text"></i>
        <span class="d-lg-block d-none">Pesan</span>
      </a>
    </li> -->
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.following') ? 'active' : '' }}"
        href="{{ route('dashboard.following') }}">
        <i class="icon wb-star"></i>
        <span class="d-lg-block d-none">Diikuti</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.favorite*') ? 'active' : '' }}"
        href="{{ route('dashboard.favorite') }}">
        <i class="icon wb-heart"></i>
        <span class="d-lg-block d-none">Favorit</span>
      </a>
    </li>
  </ul>
  @if(Auth::user()->minitutor && Auth::user()->minitutor->active)
  <ul class="ab-dashboard__nav-quick nav-quick nav-quick-sm row">
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.accepted*') ? 'active' : '' }}"
        href="{{ route('dashboard.accepted.index') }}">
        <i class="icon wb-check-circle"></i>
        <span class="d-lg-block d-none">Diterima</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.requested*') ? 'active' : '' }}"
        href="{{ route('dashboard.requested.index') }}">
        <i class="icon wb-order"></i>
        <span class="d-lg-block d-none">Diminta</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.comments*') ? 'active' : '' }}"
        href="{{ route('dashboard.comments.index') }}">
        <i class="icon wb-chat-group"></i>
        <span class="d-lg-block d-none">Komentar</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.review*') ? 'active' : '' }}"
        href="{{ route('dashboard.review.index') }}">
        <i class="icon wb-reply"></i>
        <span class="d-lg-block d-none">Ulasan</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.article*') ? 'active' : '' }}"
        href="{{ route('dashboard.article.index') }}">
        <i class="icon wb-list"></i>
        <span class="d-lg-block d-none">Artikel</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.video*') ? 'active' : '' }}"
        href="{{ route('dashboard.video.index') }}">
        <i class="icon wb-video"></i>
        <span class="d-lg-block d-none">Video</span>
      </a>
    </li>
    <li class="nav-item col">
      <a class="nav-link {{ Route::is('dashboard.followers*') ? 'active' : '' }}"
        href="{{ route('dashboard.followers.index') }}">
        <i class="icon wb-users"></i>
        <span class="d-lg-block d-none">Pengikut</span>
      </a>
    </li>
  </ul>
  @endif
</div>

<div class="container-fluid">
  {{ $slot }}
</div>