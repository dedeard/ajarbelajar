@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')
<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Daftar Minitutor yang kamu ikuti</h3>
  </div>
  <div class="panel-body">
  @if($minitutors->total())
    <div class="row">
      @foreach($minitutors as $minitutor)
      <div class="col-lg-4 mt-15">
        @component('web.components.minitutor_card')
        @slot('minitutor', $minitutor)
        @endcomponent
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada MiniTutor yang kamu ikuti.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $minitutors->links() }}
  </div>
</div>
@endcomponent
@endsection