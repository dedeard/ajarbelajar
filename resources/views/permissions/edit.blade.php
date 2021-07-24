@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Edit Permission</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('permissions.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('permissions.update', $permission->id) }}" method="post">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="name">nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama..." value="{{ $permission->name }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Permission</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
