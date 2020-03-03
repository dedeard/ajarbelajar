@extends('web.layouts.app')
@section('title', 'Edit vidio')
@section('meta')
<script>
window.SIDEBAR_CLOSE = true
</script>
@endsection
@section('content')
@component('web.dashboard.components.layoutWrapper')

<form class="row" method="POST" action="{{ route('dashboard.video.update', $video->id) }}"
  enctype="multipart/form-data">
  @csrf
  @method('put')

  <div class="col-lg-12">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Kontent</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="form-group">
          <label class="mb-3">Alamat URL Vidio</label>
          <input type="text" name="videos" class="form-control @error('videos') is-invalid @enderror"
            value="{{ $video->videos }}">
          @error('videos')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Hero</h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="p-0">
          <input type="file" name="hero" class="dropify"
            data-default-file="{{ $video->hero ? $video->heroUrl() : '' }}" />
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
          <select name="category_id"
            class="select2-basic d-block form-control @error('category_id') is-invalid @enderror">
            <option value="" disabled @if(!$video->category_id) selected @endif>Kategori</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @if($category->id === $video->category_id) selected
              @endif>{{ $category->name }}</option>
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
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
            value="{{ $video->title }}">
          @error('title')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="mb-3">Deskripsi</label>
          <textarea name="description" rows="4"
            class="form-control @error('description') is-invalid @enderror">{{ $video->description }}</textarea>
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
@endcomponent
@endsection