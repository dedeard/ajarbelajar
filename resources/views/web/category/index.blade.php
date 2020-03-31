@extends('web.layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="container-fluid mt-15">
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title">Kategori</h3>
    </div>
    <div class="panel-body bg-light">
      <div class="row">
        @foreach($categories as $category)
        <div class="col-lg-4">
          <div class="card text-center">
            <div class="card-block">
              <h3 class="card-title text-uppercase mb-4">{{ $category->name }}</h3>
              <ul class="nav-quick nav-quick-bordered row">
                <li class="nav-item col-6">
                  <span class="nav-link">
                    <i class="icon wb-video" aria-hidden="true"></i>
                    {{ $category->video_count }} Vidio
                  </span>
                </li>
                <li class="nav-item col-6">
                  <span class="nav-link">
                    <i class="icon wb-order" aria-hidden="true"></i>
                    {{ $category->article_count }} Artikel
                  </span>
                </li>
              </ul>
              <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary">Telusuri</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      {{ $categories->links() }}
    </div>
  </div>
</div>

@endsection