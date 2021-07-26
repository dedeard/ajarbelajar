@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h2 class="panel-title">{{ $article->title }}</h2>
        <div class="my-auto ml-auto">
          <a href="{{ route('request-articles.accept', $article->id) }}" class="btn btn-sm btn-primary">Terima</a>
          <button class="btn btn-danger btn-sm" delete-confirm="#form-delete-request-article">
            Hapus
          </button>
          <form action="{{ route('request-articles.destroy', $article->id) }}" method="post" id="form-delete-request-article">
            @csrf
            @method('delete')
          </form>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8">
            <span><strong>Body :</strong></span>
            {!! $body !!}
          </div>
          <div class="col-lg-4">
            <span><strong>JUDUL :</strong></span>
            <h3 class="mt-0 mb-3">{{ $article->title }}</h3>
            @if ($article->category)
              <span><strong>Kategori :</strong></span>
              <h4 class="mt-0 mb-3 text-primary">{{ $article->category->name }}</h4>
            @endif
            <span><strong>DESKRIPSI :</strong></span>
            <p class="mb-3 mt-0">{{ $article->description }}</p>
            <p class="mb-0 mt-0"><strong>Dibuat pada :</strong> {{ $article->created_at->format('d M Y') }}</p>
            <p class="mb-3 mt-0"><strong>Diedit pada :</strong> {{ $article->updated_at->format('d M Y') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
