@extends('admin.layouts.app')
@section('title', 'Minitutor')
@section('content')

<form class="row" method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data" id="app-editor-layout">
  @csrf
  @method('put')

  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Kontent</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <app-editorjs image-url="{{ route('admin.articles.image', $article->id) }}" editor-body="{{ $article->body }}"></app-editorjs>
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
        <app-hero-chose name="hero" default-img="{{ $article->thumbUrl() }}"></app-hero-chose>
      </div>
    </div>
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Informasi</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="form-group">
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
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $article->title }}">
          @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Tag</label>
          <app-tags-input :tags="{{ $article->tags }}" name="tags"></app-tags-input>
        </div>
        <div class="form-group">
          <label class="mb-3">Deskripsi</label>
          <textarea name="description"  rows="4" class="form-control @error('description') is-invalid @enderror">{{ $article->description }}</textarea>
          @error('description')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group mt-30">
          <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-primary ladda-button" data-style="slide-down">
              <span class="ladda-label">Simpan</span>
            </button>
            @if($article->draf)
              <a class="btn btn-sm btn-primary" href="{{ route('admin.articles.make.public', $article->id) }}">Publikasikan</a>
            @else
              <a class="btn btn-sm btn-primary" href="{{ route('admin.articles.make.draf', $article->id) }}">Jadikan draf</a>
            @endif
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-preview">Demo</button>
            <button delete-confirm data-target="#form-delete-article" class="btn btn-sm btn-danger">Hapus</button>
          </div>
          
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
<form id="form-delete-article" action="{{ route('admin.articles.destroy', $article->id) }}" method="POST">
  @csrf
  @method('delete')
</form>
@endsection
@section('script')

<script src="{{ mix('js/editor.js') }}"></script>
@endsection
