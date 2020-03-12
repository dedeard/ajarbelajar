@extends('web.layouts.app')
@section('content')
<div class="container-fluid">
<div class="panel mt-15">
  <div class="panel-body">
    <div class="row">
      @foreach($articles as $article)
        @component('web.components.post_list')
        @slot('post', $article)
        @endcomponent
      @endforeach
    </div>
  </div>
  <div class="panel-footer">
    {{ $articles->links() }}
  </div>
</div>
</div>
@endsection
