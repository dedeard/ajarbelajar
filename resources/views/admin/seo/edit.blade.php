@extends('admin.layouts.app')
@section('title', 'Seo')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Seo <strong>{{ $seo->name }}</strong></h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.seo.update', $seo->id) }}" method="post">
      @csrf
      @method('put')

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $seo->title }}">
        @error('title')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description">Deskripsi</label>
        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ $seo->description }}</textarea>
        @error('description')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="keywords">Kata kunci</label>
        <input type="text" name="keywords" id="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{ $seo->keywords }}">
        @error('keywords')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="robots">robots</label>
        <input type="text" name="robots" id="robots" class="form-control @error('robots') is-invalid @enderror" value="{{ $seo->robots }}">
        @error('robots')
          <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="distribution">distribution</label>
        <input type="text" name="distribution" id="distribution" class="form-control @error('distribution') is-invalid @enderror" value="{{ $seo->distribution }}">
        @error('distribution')
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
