@extends('web.layouts.app')
@section('title', 'Ketegori')
@section('content')
<div class="container-fluid mt-15">
  @foreach($posts as $post)
  @component('web.components.post_list')
  @slot('post', $post)
  @endcomponent
  @endforeach
  <div class="card card-block mb-15 empty-none">
    {{ $posts->links() }}
  </div>
</div>
@endsection