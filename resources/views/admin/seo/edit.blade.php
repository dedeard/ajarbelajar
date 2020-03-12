@extends('admin.layouts.app')
@section('title', 'Seo')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Seo <strong>{{ $name }}</strong></h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.seo.update', $slug) }}" method="post">
      @csrf
      @method('put')

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ !empty($data['title']) ? $data['title'] : '' }}">
        @error('title')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description">Deskripsi</label>
        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ !empty($data['description']) ? $data['description'] : '' }}">
        @error('description')
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
