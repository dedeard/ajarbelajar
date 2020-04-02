@extends('web.layouts.app')
@section('script')
<script src="{{ mix('js/video-uploader.js') }}"></script>
@endsection
@section('content')
@component('web.dashboard.components.layoutWrapper')
<script>
  window.SIDEBAR_CLOSE = true
</script>
<form class="row" method="POST" action="{{ route('dashboard.video.update', $video->id) }}" enctype="multipart/form-data">
  @csrf
  @method('put')

  <div class="col-lg-8">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Video</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">

        <!-- Video results -->
        <div class="row">
          @foreach($video->videos as $vid)
          <div class="col-6">
            <div class="card">
              <div class="card-block bg-light">
                <video class="img-fluid" controls>
                  <source src="{{ asset('storage/post/video/' . $vid->name) }}" />
                </video>
                <a href="{{ route('dashboard.video.video.destroy', [$video->id, $vid->id]) }}" class="btn btn-danger btn-block" delete-confirm data-target="#form-delete-video-list-{{$vid->id}}">
                  Hapus video
                </a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Video form -->
        <div class="upload-video-wrapper">
          <div class="upload-video-content">
            <p class="message" id="video-upload-message">Jatuhkan Video anda disini atau Klik disini.</p>
          </div>
          <input type="file" id="video-input" upload-url="{{ route('dashboard.video.video.upload', $video->id) }}">
        </div>
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
          <input type="file" name="hero" class="dropify" data-default-file="{{ $video->hero ? $video->heroUrl() : '' }}" />
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
          @php
          $tags = [];
          foreach($video->tags as $tag) array_push($tags, $tag->name);
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
          <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ $video->description }}</textarea>
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
        </div>
      </div>
    </div>
  </div>
</form>
@foreach($video->videos as $vid)
<form id="form-delete-video-list-{{$vid->id}}" action="{{ route('dashboard.video.video.destroy', [$video->id, $vid->id]) }}" method="post">
  @csrf
  @method('delete')
</form>
@endforeach
@endcomponent
@endsection