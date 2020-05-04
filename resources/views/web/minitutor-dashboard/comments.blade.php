@extends('web.layouts.app')
@section('content')
@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  @if($comments->total())
  @foreach($comments as $comment)
    @component('web.minitutor-dashboard.components.comment-list')
      @slot('comment', $comment)
    @endcomponent
  @endforeach
  <div class="card card-block mb-15 empty-none">
    {{ $comments->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Belum ada komentar pada artikel atau video anda.</h3>
  </div>
  @endif
</div>
@endcomponent
@endsection