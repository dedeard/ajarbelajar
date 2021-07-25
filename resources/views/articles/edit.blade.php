@extends('layouts.app')

@section('script:after')
  <script>
    $(function() {
      window.initAutocomplete('autoComplete', {!! json_encode($categories) !!}, ["name"])
      window.initEditor('editorjs', "editorResult", "{{ route('articles.upload.image', $article->id) }}");
    })
  </script>
@endsection

@section('content')
  <div class="container-fluid">
    <form class="row" method="post" enctype="multipart/form-data" action="{{ route('articles.update', $article->id) }}">
      @csrf
      @method('PUT')
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <strong>Body</strong>
          </div>
          <div class="card-body">
            <div id="editorjs"></div>
            <textarea name="body" class="d-none" id="editorResult">{{ $article->body }}</textarea>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header px-3">
            <strong>Hero</strong>
          </div>
          <div class="card-body p-3">
            <img src="{{ $article->heroUrl['thumb'] ? $article->heroUrl['thumb'] : asset('img/placeholder/hero-thumb.jpg') }}" class="img-fluid d-block w-100" />
            <div class="form-group pt-2 m-0">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="hero" id="custom-input-avatar" accept="image/*">
                <label class="custom-file-label @error('hero') border-danger @enderror" for="custom-input-avatar">Pilih Gambar</label>
              </div>
              @error('hero')
                <span class="invalid-feedback d-block">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header px-3">
            <strong>Informasi</strong>
          </div>
          <div class="card-body p-3">
            <div class="category-autocomplete">
              <div class="form-group">
                <label>Kategori</label>
                <input ref="input" placeholder="Kategori" id="autoComplete" autocomplete="off" type="text" name="category" class="autocomplete form-control @error('category') is-invalid @enderror"
                  value="{{ old('category') ?? $article->category ? $article->category->name : '' }}">
                @error('category')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label>Judul</label>
              <input placeholder="Judul" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $article->title }}">
              @error('title')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <textarea placeholder="Deskripsi" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $article->description }}</textarea>
              @error('description')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" id="public" name="public" @if (old('public') ?? (bool) $article->posted_at) checked @endif>
                <label for="public">Publikasikan artikel ini</label>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
