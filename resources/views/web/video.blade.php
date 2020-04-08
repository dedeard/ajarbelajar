@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
  @foreach($videos as $video)
    @component('web.components.post_list')
    @slot('post', $video)
    @endcomponent
  @endforeach
  <div class="card card-block mb-15 empty-none">
    {{ $videos->links() }}
  </div>
</div>
@endsection
