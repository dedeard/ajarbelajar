@extends('web.layouts.app')
@section('content')


@include('web.my-dashboard.partials.profile-card-lg')
@include('web.my-dashboard.partials.email-alert')
@include('web.my-dashboard.partials.my-dashboard-nav')


<div class="container-fluid mb-15 my-dashboard-layout">
@foreach($activities as $activity)
<a class="activity-card" href="{{ route('post.show', $activity->post->slug) }}">
  <div class="left">
    <v-lazy-image
      src="{{ $activity->post->thumbUrl() }}"
      src-placeholder="{{ asset('img/placeholder/post-sm.jpg') }}"
      alt="{{ $activity->post->title }}"
    ></v-lazy-image>
  </div>
  <div class="right">
    <div class="info-action">
      {{ $activity->updated_at->diffForHumans() }} -
      @if($activity->post->type == 'article')
      Kamu membaca artikel
      @else
      Kamu menonton video
      @endif
    </div>
    <h3 class="info-title">
      {{ $activity->post->title }}
    </h3>
  </div>
</a>
@endforeach
</div>

@endsection
