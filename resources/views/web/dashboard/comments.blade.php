@extends('web.layouts.app')
@section('title', 'Komentar')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Komentar</h3>
  </div>
  <div class="panel-body">
    @if($comments->count())
    <div class="row">
      @foreach($comments as $comment)
        <div class="col-12">
          <div class="card card-block">
            <a class="h4" href="{{ route('post.show', $comment->post->slug) }}">{{ $comment->post->title }}</a>
            <p class="m-0">dari <span class="text-primary">{{ $comment->user->name() }}</span>, {{ $comment->created_at->format('d M Y H:i') }}</p>
            <p>{{$comment->body}}</p>
          </div>
        </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Komentar Satupun.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $comments->links() }}
  </div>
</div>
@endcomponent
@endsection