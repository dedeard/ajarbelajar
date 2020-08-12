@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">MINITUTORS</h3>
        <div class="panel-actions">
          <a class="btn btn-sm btn-primary" href="{{ route('admin.minitutors.index') }}">Back</a>
          <a class="btn btn-sm btn-warning" href="{{ route('admin.minitutors.active.toggle', $minitutor->id) }}">
            @if($minitutor->active)
            Nonaktifkan
            @else
            Aktifkan
            @endif
          </a>
          <button class="btn btn-sm btn-danger" title="Delete" v-delete-confirm:form-delete-minitutor-{{ $minitutor->id }}>Delete</button>
          <form action="{{ route('admin.minitutors.destroy', $minitutor->id) }}" method="post" id="form-delete-minitutor-{{ $minitutor->id }}">
            @csrf
            @method('delete')
          </form>
        </div>
      </div>
      <div class="panel-body">

      </div>
    </div>
  </div>
@endsection
