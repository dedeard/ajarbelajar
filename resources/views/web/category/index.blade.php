@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
  @if($categories->total() || request()->input('search'))
    <form method="get" class="form-search-lg">
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari Kategori..." value="{{ request()->input('search') }}">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
        </span>
      </div>
    </form>
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
          <a href="{{ route('category.show', $category->slug) }}" class="btn btn-primary btn-sm btn-block">Telusuri</a>
        </div>
      </div>
    </div>
    @endforeach
    </div>
    @if(!$categories->total())
      <div class="py-100 panel panel-body">
        <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
      </div>
    @endif
    <div class="card card-block mb-15 empty-none">
      {{ $categories->links() }}
    </div>
  @else
    <div class="py-100 panel panel-body">
      <h3 class="text-muted text-center">Belum ada artikel atau video yang di favoritkan.</h3>
    </div>
  @endif

</div>
@endsection