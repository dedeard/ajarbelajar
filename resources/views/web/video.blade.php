@extends('web.layouts.app')
@section('content')
<div class="container-fluid">
<div class="panel mt-15">
  <div class="panel-body">
    <div class="row">
      @foreach($videos as $video)
        @component('web.components.post_list')
        @slot('post', $video)
        @endcomponent
      @endforeach
    </div>
  </div>
  <div class="panel-footer">
    {{ $videos->links() }}
  </div>
</div>
</div>
@endsection
