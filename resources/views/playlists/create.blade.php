@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Buat Playlist</h3>
        <div class="panel-actions">
          <a href="{{ route('playlists.minitutors') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('playlists.store', ['id' => $minitutor->id]) }}" method="post">
          @csrf

          <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
            @error('title')
              <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Deskripsi</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">
              {{ old('description') }}
            </textarea>
            @error('description')
              <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Playlist</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
