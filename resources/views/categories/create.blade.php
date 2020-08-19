@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">CREATE CATEGORY</h3>
        <div class="panel-actions">
          <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('categories.store') }}" method="post">
          @csrf

          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
            @error('name')
              <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
