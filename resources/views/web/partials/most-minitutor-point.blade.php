<div class="most-minitutor-point">
  <div class="most-minitutor-point-header">
    <h3 class="most-minitutor-point-title">MiniTutor dengan Poin terbanyak</h3>
    <div class="most-minitutor-point-links">
      <!-- <a href="#" class="btn btn-primary btn-sm">Poin Minitutor?</a> -->
    </div>
  </div>
  <div class="row">
    @foreach(\App\Model\Minitutor::orderBy('points', 'desc')->limit(4)->get() as $minitutor)
    <div class="col-lg-3">
      <a class="most-minitutor-point-card" href="{{ route('minitutor.show', $minitutor->user->username) }}">
        <div class="avatar">
          <v-lazy-image
            src="{{ $minitutor->user->imageUrl() }}"
            src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
            alt="{{ $minitutor->user->username }}"
            class="avatar-holder"
          ></v-lazy-image>
        </div>
        <h4 class="info-name text-truncate">{{ $minitutor->user->name() }}</h4>
        <span class="info-point">{{ $minitutor->points }} Poin</span>
      </a>
    </div>
    @endforeach
  </div>
</div>