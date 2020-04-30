<div class="most-user-point">
  <div class="most-user-point-header">
    <h3 class="most-user-point-title">Pengguna dengan Poin terbanyak</h3>
    <div class="most-user-point-links">
      <!-- <a href="#" class="btn btn-primary btn-sm">Poin user?</a> -->
    </div>
  </div>
  <div class="row">
    @foreach(\App\Model\User::orderBy('points', 'desc')->limit(4)->get() as $user)
    <div class="col-lg-3">
      <a class="most-user-point-card" href="{{ route('users.show', $user->username) }}">
        <div class="avatar">
          <v-lazy-image
            src="{{ $user->imageUrl() }}"
            src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
            alt="{{ $user->username }}"
            class="avatar-holder"
          ></v-lazy-image>
        </div>
        <h4 class="info-name text-truncate">{{ $user->name() }}</h4>
        <span class="info-point">{{ $user->points }} Poin</span>
      </a>
    </div>
    @endforeach
  </div>
</div>