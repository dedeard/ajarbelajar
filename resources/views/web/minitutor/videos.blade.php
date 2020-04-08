@extends('web.layouts.app')
@section('content')
@component('web.minitutor.components.layout')
@slot('minitutor', $minitutor)

@if($videos->total() || request()->input('search'))
  <form method="get" class="form-search-lg">
    <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Cari Postingan yang diterima.." value="{{ request()->input('search') }}">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
      </span>
    </div>
  </form>
  @foreach($videos as $post)
    @component('web.components.post_list')
      @slot('post', $post)
    @endcomponent
  @endforeach
  @if(!$videos->total())
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
  </div>
  @endif
  <div class="card card-block mb-15 empty-none">
    {{ $videos->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">MiniTutor belum mempunyai Video.</h3>
  </div>
  @endif

@endcomponent
@endsection