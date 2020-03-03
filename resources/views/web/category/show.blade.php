@extends('web.layouts.app')
@section('title', 'Ketegori')
@section('content')
<div class="container-fluid mt-15">
  <div class="panel panel-bordered">
    <div class="panel-body bg-light">
      <div class="row">
        @foreach($posts as $post)
          @component('web.components.post_list')
          @slot('post', $post)
          @endcomponent
        @endforeach
      </div>
    </div>
    <div class="panel-footer">
      {{ $posts->links() }}
    </div>
  </div>
</div>

@endsection
