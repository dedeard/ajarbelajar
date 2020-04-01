@extends('admin.layouts.app')
@section('title', 'Create Seo')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Create Seo</strong></h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.seo.store') }}" method="post">
      @csrf

      <div class="form-group">
        <label for="path">Path</label>
        <input type="text" name="path" id="path" class="form-control @error('path') is-invalid @enderror" value="{{ old('path') }}">
        @error('path')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
        @error('title')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
        @error('description')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="type">Type</label>
        <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ old('type') }}">
        @error('type')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="robots">robots</label>
        <input type="text" name="robots" id="robots" class="form-control @error('robots') is-invalid @enderror" value="{{ old('robots') }}">
        @error('robots')
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
