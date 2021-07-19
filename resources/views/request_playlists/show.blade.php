@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h2 class="panel-title">{{ $playlist->title }}</h2>
        <div class="my-auto ml-auto">
          <a href="{{ route('request-playlists.accept', $playlist->id) }}" class="btn btn-sm btn-primary">Terima</a>
          <button class="btn btn-danger btn-sm" v-delete-confirm:form-delete-playlist>
            Hapus
          </button>
          <form action="{{ route('request-playlists.destroy', $playlist->id) }}" method="post" id="form-delete-playlist">
            @csrf
            @method('delete')
          </form>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-lg-8">
            <span><strong>VIDEO :</strong></span>
            <div class="row no-gutters p-0">
              @foreach ($videos as $video)
                <div class="col-md-6">
                  <app-video-simple src="{{ $video['url'] }}" :autoplay="false" />
                </div>
              @endforeach
            </div>
          </div>
          <div class="col-lg-4">
            <span><strong>JUDUL :</strong></span>
            <h3 class="mt-0 mb-3">{{ $playlist->title }}</h3>
            @if ($playlist->category)
              <span><strong>Kategori :</strong></span>
              <h4 class="mt-0 mb-3 text-primary">{{ $playlist->category->name }}</h4>
            @endif
            <span><strong>DESKRIPSI :</strong></span>
            <p class="mb-3 mt-0">{{ $playlist->description }}</p>
            <p class="mb-0 mt-0"><strong>Dibuat pada :</strong> {{ $playlist->created_at->format('d M Y') }}</p>
            <p class="mb-3 mt-0"><strong>Diedit pada :</strong> {{ $playlist->updated_at->format('d M Y') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
