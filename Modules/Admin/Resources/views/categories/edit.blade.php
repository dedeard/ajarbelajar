@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">EDIT CATEGORY</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
          @csrf
          @method('put')

          <div class="form-group">
            <label for="name">name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Category</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
