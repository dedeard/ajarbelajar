@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Daftar Artikel dan Video Favorit kamu</h3>
  </div>
  <div class="panel-body">
    @if($posts->total())
    <div class="row">
      @foreach($posts as $post)
      @component('web.components.post_list')
        @slot('post', $post)
      @endcomponent
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Artikel atau Video yang kamu favoritkan.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $posts->links() }}
  </div>
</div>
@endcomponent
@endsection