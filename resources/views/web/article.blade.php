@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
  @foreach($articles as $article)
    @component('web.components.post_list')
    @slot('post', $article)
    @endcomponent
  @endforeach
  <div class="card card-block mb-15 empty-none">
    {{ $articles->links() }}
  </div>
</div>
@endsection
