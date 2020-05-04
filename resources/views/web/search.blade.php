@extends('web.layouts.app')
@section('content')

<div class="container-fluid mt-15">
  <div class="panel">
    <div class="panel-body">
      @if($posts->total() > 0)
      <h1 class="page-search-title">{{ $posts->total() }} Hasil Dari Pencarian "{{ request()->input('search') }}"</h1>
      <ul class="list-group list-group-full list-group-dividered">
        @foreach($posts as $post)
        <li class="list-group-item flex-column align-items-start">
          <h4><a href="{{ route('post.show', $post->slug) }}">{{ $post->title }}</a></h4>
          <a class="search-result-link" href="{{ route('post.show', $post->slug) }}">{{ route('post.show', $post->slug) }}</a>
          <p>{{ $post->description }}</p>
        </li>
        @endforeach
      </ul>
      {{ $posts->links() }}
      @else
      <div class="py-100">
        <h3 class="text-center">Tidak ada hasil pencarian dari "{{ request()->input('search') }}"</h3>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection