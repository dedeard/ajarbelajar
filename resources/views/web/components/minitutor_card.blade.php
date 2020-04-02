<div class="card card-shadow text-center cover white">
  <div class="cover-background" style="background-image: url({{ asset('img/background/snow.jpg') }})">
    <div class="card-block p-15 overlay-background ">
      <a class="avatar avatar-100 bg-white mb-10 m-xs-0 img-bordered" href="{{ route('minitutor.show', $minitutor->user->username) }}">
        <img src="{{ $minitutor->user->imageUrl() }}" alt="{{ $minitutor->user->name() }}">
      </a>
      <div class="font-size-20 text-capitalize">{{ $minitutor->user->name() }}</div>
      <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="font-size-14 text-lowercase text-light">{{ '@' . $minitutor->user->username }}</a>
    </div>
    
  </div>
  <div class="card-footer bg-white">
    <div class="card-block">
      <a href="{{ route('minitutor.show', $minitutor->user->username) }}" class="btn btn-primary btn-sm btn-block">Lihat Minitutor</a>
      @if(Auth::user() && Auth::user()->hasSubscribed($minitutor))
        <a href="{{ route('followable.unfollow', $minitutor->user->id) }}" class="btn btn-primary btn-sm btn-block">Berhenti Mengikuti</a>
      @else
        <a href="{{ route('followable.follow', $minitutor->user->id) }}" class="btn btn-primary btn-sm btn-block">Ikuti</a>
      @endif
    </div>
    <div class="row">
      <div class="col-4">
        <div class="counter">
          <div class="counter-label">Pengikut</div>
          <span class="counter-number">{{ $minitutor->subscribers->count() }}</span>
        </div>
      </div>
      <div class="col-4">
        <div class="counter">
          <div class="counter-label">Artikel</div>
          <span class="counter-number">{{ $minitutor->user->articleCount() }}</span>
        </div>
      </div>
      <div class="col-4">
        <div class="counter">
          <div class="counter-label">Vidio</div>
          <span class="counter-number">{{ $minitutor->user->videoCount() }}</span>
        </div>
      </div>
    </div>
  </div>
  <div class="card-footer">
    @if($minitutor->user->website_url)
    <a href="{{ $minitutor->user->website_url }}" target="_blank" class="btn btn-icon btn-primary">
      <i class="icon wb-globe"></i>
    </a>
    @endif
    @if($minitutor->user->twitter_url)
    <a href="{{ $minitutor->user->twitter_url }}" target="_blank" class="btn btn-icon social-twitter">
      <i class="icon socicon-twitter"></i>
    </a>
    @endif
    @if($minitutor->user->instagram_url)
    <a href="{{ $minitutor->user->instagram_url }}" target="_blank" class="btn btn-icon social-instagram">
      <i class="icon socicon-instagram"></i>
    </a>
    @endif
    @if($minitutor->user->facebook_url)
    <a href="{{ $minitutor->user->facebook_url }}" target="_blank" class="btn btn-icon social-facebook">
      <i class="icon socicon-facebook"></i>
    </a>
    @endif
    @if($minitutor->user->youtube_url)
    <a href="{{ $minitutor->user->youtube_url }}" target="_blank" class="btn btn-icon social-youtube">
      <i class="icon socicon-youtube"></i>
    </a>
    @endif
  </div>
</div>