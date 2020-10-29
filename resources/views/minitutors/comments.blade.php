@extends('layouts.app')

@section('content')
  @component('components.minitutor_show', ['minitutor' => $minitutor])
    @foreach ($comments as $comment)
      <div class="comment-list">
        <div class="comment-list-info">
          <div class="comment-list-left">
            <div class="user-pic">
              <a href="{{ route('users.show', $comment->user->id) }}" class="avatar">
                <img class="avatar-holder" src="{{ $comment->user->avatar_url }}" />
              </a>
            </div>
          </div>
          <div class="comment-list-right">
            <h5 class="comment-list-info-name">
              <a href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
            </h5>
            <span class="comment-list-info-date">{{ $comment->created_at->format('y m d') }}</span>
            <p class="comment-list-info-message">{{ $comment->body }}</p>
          </div>
        </div>
      </div>
    @endforeach
  @endcomponent
@endsection
