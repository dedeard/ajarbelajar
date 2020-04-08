@extends('web.layouts.app')
@section('content')
@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  <div class="panel panel-body p-15">
    <a href="{{ route('dashboard.minitutor.articles.create') }}" class="btn btn-primary btn-block">Buat Artikel Baru</a>
  </div>
  @if($articles->total() || request()->input('search'))
  <form method="get" class="form-search-lg">
    <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Cari Artikel.." value="{{ request()->input('search') }}">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
      </span>
    </div>
  </form>
  @foreach($articles as $article)
    @component('web.minitutor-dashboard.components.request-post-list')
      @slot('post', $article)
    @endcomponent
  @endforeach
  @if(!$articles->total())
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
  </div>
  @endif
  <div class="card card-block mb-15 empty-none">
    {{ $articles->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body text-center">
    <h3 class="text-muted">Belum ada Artikel</h3>
    <a href="{{ route('dashboard.minitutor.articles.create') }}" class="btn btn-primary px-30">Buat Artikel</a>
  </div>
  @endif
</div>
@endcomponent
@endsection