@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Buat Role</h3>
        <div class="panel-actions">
          <a href="{{ route('roles.index') }}" class="btn btn-sm btn-primary">Batal</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('roles.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama..." value="{{ old('name') }}">
            @error('name')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Role</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
