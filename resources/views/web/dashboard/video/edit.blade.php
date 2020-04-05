@extends('web.layouts.editor')
@section('content')
<form class="ab-editor-layout" id="app-editor-layout" method="POST" action="{{ route('dashboard.video.update', $video->id) }}" enctype="multipart/form-data">
  @csrf
  @method('put')
  <header class="ab-header">
    <div class="ab-header__wrapper">
      <div class="ab-header__left">
        <a href="{{ route('dashboard.video.index') }}" class="ab-header__left-brand">
          <img src="{{ asset('img/logo/logo-white.svg') }}" alt="">
        </a>
      </div>
      <div class="ab-header__right">
        <div class="ab-header__right-actions">
          <a href="{{ route('dashboard.video.index') }}" class="btn btn-default">Batalkan</a>
        </div>
      </div>
    </div>
  </header>
  <div class="ab-content">
    <div class="container-fluid">
      <div class="row">
        @csrf
        @method('put')

        <div class="col-lg-9">
          <div class="panel panel-bordered">
            <div class="panel-heading">
              <h3 class="panel-title">Video</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                @foreach($video->videos as $vid)
                <div class="col-6">
                  <div class="card">
                    <div class="card-block bg-light">
                      <video class="img-fluid" controls>
                        <source src="{{ asset('storage/post/video/' . $vid->name) }}" />
                      </video>
                      <button type="button" class="btn btn-danger btn-block" v-delete-confirm:form-des-video-list-{{$vid->id}}>
                        Hapus video
                      </button>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
              <app-video-uploader upload-url="{{ route('dashboard.video.video.upload', $video->id) }}"></app-video-uploader>
            </div>
          </div>
        </div>


        <div class="col-lg-3">

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
              <div class="form-group @error('last_education') has-invalid @enderror">
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
                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ $video->description }}</textarea>
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
      </div>
    </div>
  </div>
</form>
@foreach($video->videos as $vid)
<form id="form-des-video-list-{{$vid->id}}" action="{{ route('dashboard.video.video.destroy', [$video->id, $vid->id]) }}" method="post" class="d-none">
  @csrf
  @method('delete')
</form>
@endforeach

@endsection