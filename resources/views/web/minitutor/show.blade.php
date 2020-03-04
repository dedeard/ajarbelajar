@extends('web.layouts.app')
@section('title', 'Minitutor')
@section('content')
<script>
window.SIDEBAR_CLOSE = true
</script>
<div class="container-fluid">
<div class="row">
  <div class="col-lg-3 mt-15">
    @component('web.components.minitutor_card')
      @slot('minitutor', $user->minitutor)
    @endcomponent
  </div>
  <div class="col-lg-9 mt-15">
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title">Daftar Postingan</h3>
    </div>
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
</div>
</div>
@endsection
