<div class="minitutor-card">
  <div class="minitutor-card-top">
    <div class="minitutor-card-user-pic">
      <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="avatar">
        <v-lazy-image
          class="avatar-holder"
          src="{{ $minitutor->user->imageUrl() }}"
          src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
          alt="{{ $minitutor->user->username }}"
        ></v-lazy-image>
        <span class="minitutor-point">{{ $minitutor->user->points }} Poin</span>
      </a>
    </div>
    <div class="minitutor-card-content">
      <div class="minitutor-card-content-header">
        <h3 class="minitutor-card-content-title">
          <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="name">{{ $minitutor->user->name() }}</a>
          <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="username">{{ '@' . $minitutor->user->username }}</a>
        </h3>
        <div class="minitutor-card-content-actions">
          <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="btn btn-primary btn-sm">Lihat MiniTutor</a>
          @if(Auth::user() && Auth::user()->hasSubscribed($minitutor))
            <a rel="nofollow" href="{{ route('followable.unfollow', $minitutor->user->id) }}" class="btn btn-danger btn-sm">Berhenti mengikuti</a>
          @else
            <a rel="nofollow" href="{{ route('followable.follow', $minitutor->user->id) }}" class="btn btn-primary btn-sm">Ikuti MiniTutor</a>
          @endif
        </div>
      </div>
      <div class="minitutor-card-content-social-info">
        @if($minitutor->user->website_url)
        <a href="{{ $minitutor->user->website_url }}" rel="noreferrer" target="_blank">
          <i class="icon wb-globe"></i>
        </a>
        @endif
        @if($minitutor->user->twitter_url)
        <a href="{{ $minitutor->user->twitter_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-twitter"></i>
        </a>
        @endif
        @if($minitutor->user->instagram_url)
        <a href="{{ $minitutor->user->instagram_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-instagram"></i>
        </a>
        @endif
        @if($minitutor->user->facebook_url)
        <a href="{{ $minitutor->user->facebook_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-facebook"></i>
        </a>
        @endif
        @if($minitutor->user->youtube_url)
        <a href="{{ $minitutor->user->youtube_url }}" rel="noreferrer" target="_blank">
          <i class="icon socicon-youtube"></i>
        </a>
        @endif
      </div>
      <div class="minitutor-card-content-user-info">
        @if($minitutor->last_education && $minitutor->last_education !== '-')
        <div class="minitutor-card-content-user-info-detail">
          <i class="icon wb-small-point"></i> <strong>{{$minitutor->last_education}}</strong>
        </div>
        @endif
        @if($minitutor->majors && $minitutor->majors !== '-')
        <div class="minitutor-card-content-user-info-detail">
          <i class="icon wb-small-point"></i> {{$minitutor->majors}}
        </div>
        @endif
        @if($minitutor->university && $minitutor->university !== '-')
        <div class="minitutor-card-content-user-info-detail">
          <i class="icon wb-small-point"></i> {{$minitutor->university}}
        </div>
        @endif
        @if($minitutor->city_and_country_of_study && $minitutor->city_and_country_of_study !== '-')
        <div class="minitutor-card-content-user-info-detail">
          <i class="icon wb-small-point"></i> {{$minitutor->city_and_country_of_study}}
        </div>
        @endif
      </div>
    </div>
  </div>
  <div class="minitutor-card-footer">
    <div class="row">
      <div class="col-4 minitutor-card-counter-wrapper">
        <div class="minitutor-card-counter">
          <div class="minitutor-card-counter-icon">
            <i class="wb wb-users"></i>
          </div>
          <div class="minitutor-card-counter-info">
            <div class="minitutor-card-counter-title">Pengikut</div>
            <span class="minitutor-card-counter-number">{{ $minitutor->subscribers->count() }}</span>
          </div>
        </div>
      </div>
      <div class="col-4 minitutor-card-counter-wrapper">
        <div class="minitutor-card-counter">
          <div class="minitutor-card-counter-icon">
            <i class="wb wb-clipboard"></i>
          </div>
          <div class="minitutor-card-counter-info">
            <div class="minitutor-card-counter-title">Artikel</div>
            <span class="minitutor-card-counter-number">{{ $minitutor->user->articleCount() }}</span>
          </div>
        </div>
      </div>
      <div class="col-4 minitutor-card-counter-wrapper">
        <div class="minitutor-card-counter">
          <div class="minitutor-card-counter-icon">
            <i class="wb wb-play"></i>
          </div>
          <div class="minitutor-card-counter-info">
            <div class="minitutor-card-counter-title">Video</div>
            <span class="minitutor-card-counter-number">{{ $minitutor->user->videoCount() }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>