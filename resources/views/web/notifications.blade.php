@extends('web.layouts.app')
@section('content')

<div class="container-fluid mt-15">
  <div class="panel panel-bordered">
    @if($notifications->total() > 0)
    <div class="panel-heading">
      <h3 class="panel-title">{{ $notifications->total() }} Notifikasi</h3>
    </div>
    @endif
    <div class="panel-body">
      @if($notifications->total() > 0)
      <ul class="list-group list-group-full list-group-dividered">
        @foreach($notifications as $post)

        @endforeach
      </ul>
      {{ $notifications->links() }}
      @else
      <div class="py-100">
        <h3 class="text-center"> Tidak ada Notifikasi</h3>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection