@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Dafatar Artikel yang sedang kamu kelola.</h3>
  </div>
  <div class="panel-body bg-light">
    <form method="POST" action="{{ route('dashboard.article.store') }}">
      @csrf
      <div class="form-group">
        <label class="mb-3">Buat artikel baru <span class="text-danger">*</span></label>
        <input name="title" class="form-control @error('title') is-invalid @enderror" type="text" value="{{ old('title') }}" placeholder="Judul artikel" />
        @error('title')
        <div class="invalid-feedback">
          <strong>{{ $message }}</strong>
        </div>
        @enderror
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Buat artikel</button>
      </div>
    </form>
  </div>
  <div class="panel-body">
    @if($articles->total())
    <div class="row">
      @foreach($articles as $article)
      <div class="col-lg-4">
        <div class="panel panel-primary panel-line shadow">
          <div class="panel-heading">
            <h3 class="panel-title text-capitalize text-truncate">{{ $article->title }}</h3>
          </div>
          <div class="panel-body">
            <p>Di Edit {{ $article->updated_at->diffForHumans() }}</p>
            <div class="btn-group">
              <a href="{{ route('dashboard.requested.create', $article->id) }}"
                class="btn btn-sm btn-icon btn-outline btn-default" data-toggle="tooltip" title="Publikasikan">
                <i class="icon wb-globe"></i>
              </a>
              <a href="{{ route('dashboard.article.edit', $article->id) }}"
                class="btn btn-sm btn-icon btn-outline btn-default" data-toggle="tooltip" title="Edit">
                <i class="icon wb-edit"></i>
              </a>
              <a href="#" class="btn btn-sm btn-icon btn-outline btn-default" delete-confirm
                data-target="#form-delete-article-{{$article->id}}" data-toggle="tooltip" title="Hapus">
                <i class="icon wb-trash"></i>
              </a>
            </div>
            <form id="form-delete-article-{{$article->id}}"
              action="{{ route('dashboard.article.destroy', $article->id) }}" method="post">
              @csrf
              @method('delete')
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Artikel.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $articles->links() }}
  </div>
</div>
@endcomponent
@endsection