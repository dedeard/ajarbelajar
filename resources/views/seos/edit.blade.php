@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Edit SEO</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('seos.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('seos.update', $seo->id) }}" method="post">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="path">Path</label>
            <input type="text" class="form-control @error('path') is-invalid @enderror" id="path" name="path" placeholder="Path..." value="{{ old('path') ?? $seo->path }}">
            @error('path')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title..." value="{{ old('title') ?? $seo->title }}">
            @error('title')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
              placeholder="Description...">{{ old('description') ?? $seo->description }}</textarea>
            @error('description')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit SEO</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
