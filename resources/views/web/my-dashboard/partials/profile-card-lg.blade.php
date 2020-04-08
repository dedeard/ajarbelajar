<div class="container-fluid">
  <div class="ab-profile-card-lg">
    <div class="avatar">
      <img src="{{ Auth::user()->imageUrl() }}" alt="{{ Auth::user()->username }}">
    </div>
    <div class="info">
      <h3 class="name">{{ Auth::user()->name() }}</h3>
      <p class="username">{{ '@' . Auth::user()->username }}</p>
      @if(Auth::user()->email_verified_at === null)
      <span class="email-info unverified">Tidak Diverifikasi</span>
      @else
      <span class="email-info verified">Diverifikasi</span>
      @endif
    </div>
  </div>
</div>