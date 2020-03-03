@extends('web.layouts.app')
@section('title', 'Pengikut')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Pengikut</h3>
  </div>
  <div class="panel-body">
    @if($followers->total())
    <div class="row">
      @foreach($followers as $user)
      <div class="col-lg-3">
        <div class="card card-shadow text-center cover white">
          <div class="cover-background" style="background-image: url({{ asset('img/background/snow.jpg') }})">
            <div class="card-block p-15 overlay-background ">
              <a class="avatar avatar-100 bg-white mb-10 m-xs-0 img-bordered" href="javascript:void(0)">
                <img src="{{ $user->imageUrl() }}" alt="{{ $user->username }}">
              </a>
              <div class="font-size-20 text-capitalize">{{ $user->name() }}</div>
              <a href="#" class="font-size-14 text-lowercase text-light">{{ '@' . $user->username }}</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Permintaan Satupun.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $followers->links() }}
  </div>
</div>
@endcomponent
@endsection