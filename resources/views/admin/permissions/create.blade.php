@extends('admin.layouts.app')
@section('title', 'Create Permission')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Create Permission</h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.permissions.store') }}" method="post">
      @csrf

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
        @error('name')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
          <span class="ladda-label">Simpan</span>
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
