@extends('web.layouts.app')
@section('title', 'Minitutor')
@section('content')
<div class="container-fluid">
  <div class="row">
    @foreach($minitutors as $minitutor)
    <div class="col-lg-4 mt-15">
      @component('web.components.minitutor_card')
        @slot('minitutor', $minitutor)
      @endcomponent
    </div>
    @endforeach
  </div>
  <div class="p-15">
    {{ $minitutors->links() }}
  </div>
</div>
@endsection
