@extends('admin.layouts.app')

@section('title', $minitutor->user->name())
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">MiniTutor <strong>{{ $minitutor->user->name() }}</strong></h3>
    <div class="panel-actions">
      @if(!$minitutor->user->hasRole('Super Admin'))
          @if($minitutor->active)
          <a class="btn btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor->id) }}">Non aktivkan</a>
          @else
          <a class="btn btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor->id) }}">Aktivkan</a>
          @endif
          <a class="btn btn-danger" delete-confirm data-target="#form-delete-minitutor-{{$minitutor->id}}" href="#">Hapus</a>

          <form action="{{ route('admin.minitutor.destroy', $minitutor->id) }}" id="form-delete-minitutor-{{$minitutor->id}}" method="post" class="d-none">
            @csrf
            @method('delete')
          </form>
      @endif
    </div>
  </div>
  <div class="panel-body">
  </div>
</div>
@endsection