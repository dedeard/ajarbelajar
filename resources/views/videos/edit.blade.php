@extends('layouts.app')

@section('script:after')
  <script>
    $(function() {
      window.initAutocomplete('autoComplete', {!! json_encode($categories) !!}, ["name"])

      const $error = $('#upload-error')
      const $name = $('#upload-name')
      const $message = $('#upload-message')
      const $toggle = $('#upload-toggle')
      const $input = $('#video-input')

      $toggle.on('click', function() {
        $input.click()
      })

      $input.on('change', function(e) {
        const file = e.target.files ? e.target.files[0] : null
        if (file) {
          const data = new window.FormData()
          data.append('file', file)

          $error.addClass('d-none')
          $toggle.addClass('d-none')

          $name.removeClass('d-none')
          $message.removeClass('d-none')

          $name.text('Sedang menupload ' + file.name)

          window.axios
            .post($input.attr('upload-url'), data, {
              onUploadProgress: function(ev) {
                var percentCompleted = Math.round((ev.loaded * 100) / ev.total)
                if (percentCompleted === 100) {
                  $name.text('Video anda sedang diproses...')
                } else {
                  $name.text('Mengupload total ' + percentCompleted + '%')
                }
              }
            })
            .then((res) => {
              window.location.reload(true)
            })
            .catch(err => {
              $name.addClass('d-none')
              $message.addClass('d-none')

              $error.removeClass('d-none')

              let mess = ''
              if (err.response && err.response.data && err.response.data.message) {
                $error.text(err.response.data.message)
              } else {
                $error.text('Gagal mengupload file!')
              }
              $toggle.removeClass('d-none')
            })
        }
      })
    })
  </script>
@endsection

@section('content')
  <div class="container-fluid">
    <input type="file" class="d-none" id="video-input" accept="video/*" upload-url="{{ route('videos.upload.video', $video->id) }}">
    <form class="row" method="post" enctype="multipart/form-data" action="{{ route('videos.update', $video->id) }}">
      @csrf
      @method('PUT')
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <strong>Body</strong>
          </div>
          <div class="card-body p-0">
            <div class="w-full">
              <video controls src="{{ $video->videoUrl }}" class="d-block w-100"></video>
            </div>
          </div>
          <div class="card-body">
            <p class="text-center text-danger d-none" id="upload-error"></p>
            <p class="text-center d-none" id="upload-name"></p>
            <p class="text-center d-none" id="upload-message"></p>
            <div class="text-center">
              <button class="btn btn-default" id="upload-toggle" type="button">PILIH VIDEO UNTUK DI UPLOAD</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header px-3">
            <strong>Hero</strong>
          </div>
          <div class="card-body p-3">
            <img src="{{ $video->heroUrl['thumb'] ? $video->heroUrl['thumb'] : asset('img/placeholder/hero-thumb.jpg') }}" class="img-fluid d-block w-100" />
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
                  value="{{ old('category') ?? $video->category ? $video->category->name : '' }}">
                @error('category')
                  <div class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label>Judul</label>
              <input placeholder="Judul" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $video->title }}">
              @error('title')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <textarea placeholder="Deskripsi" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $video->description }}</textarea>
              @error('description')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>

            <div class="form-group">
              <div class="checkbox-custom checkbox-primary">
                <input type="checkbox" id="public" name="public" @if (old('public') ?? (bool) $video->posted_at) checked @endif>
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
