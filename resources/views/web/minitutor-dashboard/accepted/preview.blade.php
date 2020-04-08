@extends('web.layouts.app')
@section('content')
@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title">Detail Post</h3>
    </div>
    <div class="panel-body">
      <div class="font-weight-bold">Title</div>
      <h4 class="mt-0">{{ $post->title }}</h4>
      <div class="font-weight-bold">Deskripsi</div>
      <p>{{ $post->description }}</p>
      <table class="table table-bordered">
        <tr>
          <th>Diterima Pada</th>
          <td>{{ $post->created_at->diffForHumans() }}</td>
        </tr>
        <tr>
          <th>Diupdate Pada</th>
          <td>{{ $post->updated_at->diffForHumans() }}</td>
        </tr>
        <tr>
          <th>Unique view</th>
          <td>{{ $post->views_count }}</td>
        </tr>
        <tr>
          <th>Total view</th>
          <td>{{ $post->allViewCount() }}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="panel panel-bordered">
    <div class="panel-body p-0">
      <img class="img-fluid" src="{{ $post->heroUrl() }}" alt="{{ $post->title }}">
    </div>
    <div class="panel-body">
      <h1>{{ $post->title }}</h1>
      <hr class="my-15">
      {!! EditorjsHelp::compile($post->body) !!}
      <hr class="my-15">
      @foreach($post->tags as $tag)
      <a href="{{ route('tags', $tag->slug) }}" class="btn btn-xs btn-primary">{{ $tag->name }}</a>
      @endforeach
    </div>
  </div>
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title text-uppercase"><strong>Feedback Konstruktif {{ $post->reviews()->count() }}</strong></h3>
    </div>
    <div class="panel-body p-0">
      @if($post->reviews()->count() > 0)
        @foreach($post->reviews as $review)
          @component('web.minitutor-dashboard.components.feedback-list')
            @slot('review', $review)
            @slot('inPanel', 'in-panel')
          @endcomponent
        @endforeach
      @else
      <h4 class="my-40 text-center grey-500">Belum ada Feedback Konstruktif pada postingan ini.</h4>
      @endif
    </div>
  </div>
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title text-uppercase"><strong>Komentar {{ $post->comments()->where('approved', 1)->count() }}</strong></h3>
    </div>
    <div class="panel-body p-0">
      @if($post->comments()->where('approved', 1)->count() > 0)
        @foreach($post->comments()->where('approved', 1)->orderBy('created_at', 'desc')->get() as $comment)
          @component('web.minitutor-dashboard.components.comment-list')
            @slot('comment', $comment)
            @slot('inPanel', 'in-panel')
          @endcomponent
        @endforeach
      @else
      <h4 class="my-40 text-center grey-500">Belum ada Komentar pada postingan ini.</h4>
      @endif
    </div>
  </div>
</div>
@endcomponent
@endsection