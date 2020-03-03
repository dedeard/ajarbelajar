@extends('web.layouts.app')
@section('title', 'Vidio Favorit')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Vidio Favorit</h3>
    <div class="panel-actions">
      <a href="{{ route('dashboard.favorite.article') }}" class="btn btn-primary btn-sm">Artikel Favorite</a>
    </div>
  </div>
  <div class="panel-body">
    @if($videos->total())
    <div class="row">
      @foreach($videos as $video)
      @component('web.components.post_list')
        @slot('post', $video)
      @endcomponent
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Permintaan Satupun.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $videos->links() }}
  </div>
</div>
@endcomponent
@endsection