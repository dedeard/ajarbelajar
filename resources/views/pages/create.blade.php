@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Buat Halaman</h3>
        <div class="panel-actions">
          <a href="{{ route('pages.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('pages.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="slug">slug</label>
            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" placeholder="slug..." value="{{ old('slug') }}">
            @error('slug')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title..." value="{{ old('title') }}">
            @error('title')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description...">{{ old('description') }}</textarea>
            @error('description')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Halaman</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
