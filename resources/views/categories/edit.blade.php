@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Edit Kategori</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('categories.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('categories.update', $category->id) }}" method="post">
          @csrf
          @method('put')

          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Kategori</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
