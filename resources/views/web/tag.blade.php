@extends('web.layouts.app')
@section('content')
<div class="container-fluid">
<div class="panel mt-15">
  <div class="panel-body">
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
