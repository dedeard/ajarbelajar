@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h2 class="panel-title">{{ $video->title }}</h2>
        <div class="my-auto ml-auto">
          <a href="{{ route('request-videos.accept', $video->id) }}" class="btn btn-sm btn-primary">Terima</a>
          <button class="btn btn-danger btn-sm" delete-confirm="#form-delete-video">
            Hapus
          </button>
          <form action="{{ route('request-videos.destroy', $video->id) }}" method="post" id="form-delete-video">
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
              <video src="{{ $video->video_url }}" class="d-block w-100" controls></video>
            </div>
          </div>
          <div class="col-lg-4">
            <span><strong>JUDUL :</strong></span>
            <h3 class="mt-0 mb-3">{{ $video->title }}</h3>
            @if ($video->category)
              <span><strong>Kategori :</strong></span>
              <h4 class="mt-0 mb-3 text-primary">{{ $video->category->name }}</h4>
            @endif
            <span><strong>DESKRIPSI :</strong></span>
            <p class="mb-3 mt-0">{{ $video->description }}</p>
            <p class="mb-0 mt-0"><strong>Dibuat pada :</strong> {{ $video->created_at->format('d M Y') }}</p>
            <p class="mb-3 mt-0"><strong>Diedit pada :</strong> {{ $video->updated_at->format('d M Y') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
