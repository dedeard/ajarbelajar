@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Buat Video</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('videos.minitutors') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('videos.store', ['id' => $minitutor->id]) }}" method="post">
          @csrf

          <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
            @error('title')
              <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')
              <span class="invalid-feedback font-weight-bold">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Video</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
