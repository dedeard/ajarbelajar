@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">EDIT SEO</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.seo.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('admin.seo.update', $seo->id) }}" method="post">
          @csrf
          @method('put')

          <div class="form-group">
            <label for="path">Path</label>
            <input type="text" name="path" id="path" class="form-control @error('path') is-invalid @enderror" value="{{ $seo->path }}">
            @error('path')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $seo->title }}">
            @error('title')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ $seo->description }}</textarea>
            @error('description')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="type">Type</label>
            <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ $seo->type }}">
            @error('type')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="robots">robots</label>
            <input type="text" name="robots" id="robots" class="form-control @error('robots') is-invalid @enderror" value="{{ $seo->robots }}">
            @error('robots')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Seo</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
