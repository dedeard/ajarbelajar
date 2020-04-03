@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')
<script>
window.SIDEBAR_CLOSE = true
</script>
<form class="row" method="POST" action="{{ route('dashboard.article.update', $article->id) }}"
  enctype="multipart/form-data">
  @csrf
  @method('put')

  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Kontent</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <textarea name="body" id="post-editor" class="d-none">{{ $article->body }}</textarea>
        <div id="codex-editor" image-url="{{ route('dashboard.article.image', $article->id) }}"></div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Hero</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="p-0">
          <input type="file" name="hero" class="dropify" data-default-file="{{ $article->hero ? $article->heroUrl() : '' }}" />
        </div>
      </div>
    </div>
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Informasi</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="form-group @error('last_education') has-invalid @enderror">
          <label class="mb-3">Kategori</label>
          <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ $article->category ? $article->category->name : '' }}">
          @error('category')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Judul <small class="text-danger">*</small></label>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ $article->title }}">
          @error('title')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Tag</label>
          @php
            $tags = [];
            foreach($article->tags as $tag) array_push($tags, $tag->name);
            $tags = implode(',', $tags);
          @endphp
          <input type="text" class="tags-input form-controll @error('tags') is-invalid @enderror" name="tags" value="{{ $tags }}">
          @error('tags')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Deskripsi</label>
          <textarea name="description" rows="4"
            class="form-control @error('description') is-invalid @enderror">{{ $article->description }}</textarea>
          @error('description')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <div class="checkbox-custom checkbox-primary">
            <input type="checkbox" id="publish-check" name="publish">
            <label for="publish-check">Simpan dan publish.</label>
          </div>
        </div>
        <div class="form-group mt-15">
          <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
            <span class="ladda-label">Simpan</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
@endcomponent
@endsection
@section('script')

<script src="{{ mix('js/editor.js') }}"></script>
@endsection