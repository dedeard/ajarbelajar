@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">MiniTutor</h3>
        <div class="panel-actions">
          <a class="btn btn-sm btn-primary" href="{{ route('minitutors.index') }}">Kembali</a>
          <a class="btn btn-sm btn-danger" href="{{ route('minitutors.active.toggle', $minitutor->id) }}">
            @if($minitutor->active)
            Nonaktifkan
            @else
            Aktifkan
            @endif
          </a>
        </div>
      </div>
      <div class="panel-body">
        <!--  -->
      </div>
    </div>
  </div>
@endsection
