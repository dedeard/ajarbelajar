@extends('web.layouts.app')
@section('content')
@component('web.users.components.layout')
@slot('user', $user)

@foreach($activities as $activity)
<a class="activity-card" href="{{ route('post.show', $activity->post->slug) }}">
  <div class="left">
    <img src="{{ $activity->post->thumbUrl() }}" alt="">
  </div>
  <div class="right">
    <div class="info-action">
      {{ $activity->updated_at->diffForHumans() }} -
      @if($activity->post->type == 'article')
      {{ $user->first_name }} membaca Artikel
      @else
      {{ $user->first_name }} menonton Video
      @endif
    </div>
    <h3 class="info-title">
      {{ $activity->post->title }}
    </h3>
  </div>
</a>
@endforeach

@if(!$activities->count())
<div class="py-100 panel panel-body">
  <h3 class="text-muted text-center">Belum ada aktivitas.</h3>
</div>
@endif
@endcomponent
@endsection