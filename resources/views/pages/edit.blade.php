@extends('layouts.app')

@section('style:after')
  <link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
  <style>
    .fr-popup {
      z-index: 1095 !important;
    }

  </style>
@endsection

@section('script:before')
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
  <script type="text/javascript" src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
@endsection
@section('script:after')
  <script>
    var editor = new FroalaEditor('#froala', {
      imageManagerLoadURL: "{{ route('froala.image') }}",
      imageManagerDeleteURL: "{{ route('froala.image', ['_token' => csrf_token()]) }}",
      imageManagerDeleteMethod: 'DELETE',
      imageUploadURL: "{{ route('froala.image', ['_token' => csrf_token()]) }}",
      imageUploadMethod: 'POST',
    })
  </script>
@endsection


@section('content')
  <div class="container-fluid">
    <form method="post" enctype="multipart/form-data" action="{{ route('pages.update', $page->id) }}">
      @csrf
      @method('PUT')
      <div class="card">
        <div class="card-header d-flex">
          <h3>Edit Halaman</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label>Slug</label>
            <input placeholder="Slug" type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') ?? $page->slug }}">
            @error('slug')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Judul</label>
            <input placeholder="Judul" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $page->title }}">
            @error('title')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea placeholder="Deskripsi" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $page->description }}</textarea>
            @error('description')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
        </div>
        <div class="card-body">
          <textarea name="body" id="froala">{{ $page->body }}</textarea>
        </div>
        <div class="card-body">
          <div class="form-group">
            <div class="checkbox-custom checkbox-primary">
              <input type="checkbox" id="public" name="public" @if (old('public') ?? !$page->draf) checked @endif>
              <label for="public">Publikasikan halaman ini</label>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
