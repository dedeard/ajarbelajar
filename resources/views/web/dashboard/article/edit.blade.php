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
        <div id="codex-editor"></div>
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
        <div class="form-group mt-30">
          <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
            <span class="ladda-label">Simpan</span>
          </button>
          <a href="{{ route('dashboard.requested.create', $article->id) }}" class="btn btn-success">Publikasikan</a>

          <!-- Button trigger modal -->
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-preview">
            Preview
          </button>

          <!-- Modal -->
          <div class="modal fade" id="modal-preview">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Preview</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  {!! EditorjsHelp::compile($article->body) !!}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
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