@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <form class="row" method="post" enctype="multipart/form-data" action="{{ route('playlists.update', $playlist->id) }}">
      @csrf
      @method('PUT')
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header d-flex">
            <h3>Daftar Video</h3>
          </div>
          <video-order :videos="{{ json_encode($videos) }}" thumb="{{ $playlist->heroUrl()['small'] }}" upload-url="{{ route('api.admin.playlists.upload.video', $playlist->id) }}"></video-order>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="panel">
          <div class="card-header d-flex">
            <h3>Hero</h3>
          </div>
          <div class="card-body">
            <hero-chooser inline-template>
              <div class="hero-chooser">
                <img :src="url || '{{ $playlist->heroUrl()['thumb'] }}'" alt="" />
                <div class="chooser text-center pt-2">
                  <label for="hero-chooser" class="btn btn-default btn-sm btn-block m-0">@{{ name || 'Choose image' }}</label>
                  <input id="hero-chooser" type="file" class="d-none" name="hero" @change="handleChange">
                </div>
              </div>
            </hero-chooser>
          </div>
        </div>
        <div class="panel">
          <div class="card-header d-flex">
            <h3>Informasi</h3>
          </div>
          <div class="card-body">
            <category-autocomplete :categories="{{ json_encode($categories) }}" inline-template>
              <div class="form-group category-autocomplete">
                <label>Kategori</label>
                <input ref="input" id="autoComplete" placeholder="Kategori" type="text" name="category" autocomplete="off" class="form-control @error('category') is-invalid @enderror"
                  value="{{ old('category') ?? $playlist->category ? $playlist->category->name : '' }}">
                @error('category')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
            </category-autocomplete>

            <div class="form-group">
              <label>Judul</label>
              <input placeholder="Judul" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $playlist->title }}">
              @error('title')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <textarea placeholder="Deskripsi" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $playlist->description }}</textarea>
              @error('description')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" id="public" name="public" @if (old('public') ?? !$playlist->draf) checked @endif>
                <label for="public">Publikasikan playlist ini</label>
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
