@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Daftar Feedback yang ada pada Artikel dan Video</h3>
  </div>
  <div class="panel-body">
    @if($reviews->total())
      @foreach($reviews as $review)
        <div class="card card-block">
          <a class="h4" href="{{ route('post.show', $review->post->slug) }}">{{ $review->post->title }}</a>
          <p class="m-0"><strong>{{ $review->rating }} Bintang</strong>, dari <span class="text-primary">{{ $review->user->name() }}</span>, {{ $review->created_at->format('d M Y H:i') }}</p>
          <p>{{$review->body}}</p>
        </div>
      @endforeach
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Feedback.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $reviews->links() }}
  </div>
</div>
@endcomponent
@endsection