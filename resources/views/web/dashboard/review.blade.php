@extends('web.layouts.app')
@section('title', 'Ulasan')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Ulasan</h3>
  </div>
  <div class="panel-body">
    @if($reviews->total())
    <div class="row">
      @foreach($reviews as $review)
      
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Ulasan Satupun.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $reviews->links() }}
  </div>
</div>
@endcomponent
@endsection