@extends('web.layouts.app')
@section('title', 'Artikel Favorit')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Artikel Favorit</h3>
    <div class="panel-actions">
      <a href="{{ route('dashboard.favorite.video') }}" class="btn btn-primary btn-sm">Video Favorite</a>
    </div>
  </div>
  <div class="panel-body">
    @if($articles->total())
    <div class="row">
      @foreach($articles as $article)
      @component('web.components.post_list')
        @slot('post', $article)
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
    {{ $articles->links() }}
  </div>
</div>
@endcomponent
@endsection