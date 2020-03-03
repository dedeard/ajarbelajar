@extends('web.layouts.app')
@section('title', 'Postingan terbit')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Postingan terbit</h3>
  </div>
  <div class="panel-body">
    @if($accepteds->total())
    <div class="row">
      @foreach($accepteds as $accepted)
      <div class="col-lg-4">
        <div class="panel panel-primary panel-line shadow">
          <div class="panel-heading">
            <h3 class="panel-title text-capitalize text-truncate">{{ $accepted->title }}</h3>
          </div>
          <div class="panel-body">
            <p>Status {{ $accepted->status() }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Permintaan Satupun.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $accepteds->links() }}
  </div>
</div>
@endcomponent
@endsection