@extends('web.layouts.app')
@section('content')


@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  @if($reviews->total())
  @foreach($reviews as $review)
    @component('web.minitutor-dashboard.components.feedback-list')
      @slot('review', $review)
    @endcomponent
  @endforeach
  <div class="card card-block mb-15 empty-none">
    {{ $reviews->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Belum ada feedback pada artikel atau video anda.</h3>
  </div>
  @endif
</div>
@endcomponent
@endsection