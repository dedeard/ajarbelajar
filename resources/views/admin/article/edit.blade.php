@extends('admin.layouts.app')
@section('title', 'Minitutor')
@section('content')

<form class="row" method="POST" action="{{ route('admin.article.update', $article->id) }}" enctype="multipart/form-data">
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
          <input type="file" name="hero" data-plugin="dropify" data-default-file="{{ $article->hero ? $article->heroUrl() : '' }}" />
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
          <select name="category_id" data-plugin="select2" class="d-block form-control @error('category_id') is-invalid @enderror">
            <option value="" disabled @if(!$article->category_id) selected @endif>Kategori</option>
            @foreach($categories as $category)
              <option value="{{ $category->id }}" @if($category->id === $article->category_id)  selected  @endif>{{ $category->name }}</option>
            @endforeach
          </select>
          @error('category_id')
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
              <a class="btn btn-sm btn-primary" href="{{ route('admin.article.make.public', $article->id) }}">Publikasikan</a>
            @else
              <a class="btn btn-sm btn-primary" href="{{ route('admin.article.make.draf', $article->id) }}">Jadikan draf</a>
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
                  {!! Helper::compileEditorJs($article->body) !!}
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
<form id="form-delete-article" action="{{ route('admin.article.destroy', $article->id) }}" method="POST">
  @csrf
  @method('delete')
</form>
@endsection
@section('script')

<script src="{{ mix('js/editor.js') }}"></script>
@endsection
