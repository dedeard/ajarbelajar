@extends('web.layouts.app')
@section('content')
@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  <div class="panel panel-body">
    <h2 class="font-weight-bold text-center">Halo, MiniTutor <span class="text-uppercase indigo-600">{{ Auth::user()->first_name }}</span> Sukses selalu dan terima kasih atas kontribusinya dengan ajarbelajar.com</h2>
  </div>
  <div class="panel panel-bordered">
    <div class="panel-body">
      <form action="{{ route('dashboard.minitutor.articles.store') }}" method="post">
        @csrf
        <h4>Buat Artikel Baru</h4>
        <div class="form-group">
          <label class="mb-3">Judul Artikel<span class="text-danger">*</span></label>
          <input name="title" class="form-control @error('title') is-invalid @enderror" type="text" value="{{ old('title') }}" placeholder="Judul Artikel..." />
          @error('title')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Buat Artikel</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endcomponent
@endsection