@extends('admin.layouts.app')
@section('title', 'Minitutor')
@section('content')

<form class="row" method="POST" action="{{ route('admin.videos.update', $video->id) }}" enctype="multipart/form-data" id="app-editor-layout">
  @csrf
  @method('put')

  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Kontent</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <button type="button" class="btn mb-4 btn-primary btn-block" data-toggle="modal" data-target="#modal-view-videos">
          Lihat video yang dikirim MiniTutor
        </button>

        <!-- Modal -->
        <div class="modal fade" id="modal-view-videos">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title">Video yang dikirim.</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  @foreach($video->videoLists as $vid)
                  <div class="col-6">
                    <div class="card">
                      <div class="card-block bg-light">
                        <video class="img-fluid" controls>
                          <source src="{{ asset('storage/post/video/' . $vid->name) }}" />
                        </video>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
              <div class="modal-footer">
                <button delete-confirm data-target="#form-delete-video-lists" class="btn btn-sm btn-danger">Hapus Semua Video</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

        <app-editorjs image-url="{{ route('admin.videos.image', $video->id) }}" editor-body="{{ $video->body }}"></app-editorjs>
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
        <app-hero-chose name="hero" default-img="{{ $video->thumbUrl() }}"></app-hero-chose>
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
          <input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ $video->category ? $video->category->name : '' }}">
          @error('category')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Judul <small class="text-danger">*</small></label>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $video->title }}">
          @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Tag</label>
          <app-tags-input :tags="{{ $video->tags }}" name="tags"></app-tags-input>
          @error('tags')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Deskripsi</label>
          <textarea name="description"  rows="4" class="form-control @error('description') is-invalid @enderror">{{ $video->description }}</textarea>
          @error('description')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group mt-30">
          <div class="btn-group">
            <button type="submit" id="button-save" class="btn btn-sm btn-primary ladda-button" data-style="slide-down">
              <span class="ladda-label">Simpan</span>
            </button>
            @if($video->draf)
              <a class="btn btn-sm btn-primary" href="{{ route('admin.videos.make.public', $video->id) }}">Publikasikan</a>
            @else
              <a class="btn btn-sm btn-primary" href="{{ route('admin.videos.make.draf', $video->id) }}">Jadikan draf</a>
            @endif
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-preview">Demo</button>
            <button delete-confirm data-target="#form-delete-video" class="btn btn-sm btn-danger">Hapus</button>
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
                  {!! EditorjsHelp::compile($video->body) !!}
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
<form id="form-delete-video" action="{{ route('admin.videos.destroy', $video->id) }}" method="POST">
  @csrf
  @method('delete')
</form>
<form id="form-delete-video-lists" action="{{ route('admin.videos.destroy.videos', $video->id) }}" method="POST">
  @csrf
  @method('delete')
</form>
@endsection
@section('script')
<script src="{{ mix('js/editor.js') }}"></script>
@endsection 
