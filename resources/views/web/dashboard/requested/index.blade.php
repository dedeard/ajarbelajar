@extends('web.layouts.app')
@section('title', 'Permintaan Postingan')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Permintaan Postingan</h3>
  </div>
  <div class="panel-body">
    @if($requesteds->total())
    <div class="row">
      @foreach($requesteds as $requested)
      <div class="col-lg-4">
        <div class="panel panel-primary panel-line shadow">
          <div class="panel-heading">
            <h3 class="panel-title text-capitalize text-truncate">{{ $requested->title }}</h3>
          </div>
          <div class="panel-body">
            <p><span class="badge badge-primary">{{ $requested->type }}</span></p>
            <p>Diminta {{ \Carbon\Carbon::parse($requested->requested_at)->diffForHumans() }}</p>
            <div class="btn-group">
              <a href="{{ route('dashboard.requested.destroy', $requested->id) }}" class="btn btn-sm btn-danger">
                Batalkan
              </a>
            </div>
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
    {{ $requesteds->links() }}
  </div>
</div>
@endcomponent
@endsection