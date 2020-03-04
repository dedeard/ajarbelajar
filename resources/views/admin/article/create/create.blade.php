@extends('admin.layouts.app')
@section('title', 'Minitutor')
@section('content')

<form class="row" method="POST" action="{{ route('admin.article.create.store', $user->id) }}">
  @csrf

  <div class="col-lg-12">

    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title">Buat artikel untuk minitutor <strong class="text-capitalize">{{ $user->name() }}</strong></h3>
      </div>
      <hr class="m-0">
      <div class="panel-body">
        <div class="form-group">
          <label class="mb-3">Judul artikel</label>
          <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
          @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <div class="form-group mt-30">
          <div class="btn-group">
            <button type="submit" class="btn btn-sm btn-primary ladda-button" data-style="slide-down">
              <span class="ladda-label">Simpan</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection
