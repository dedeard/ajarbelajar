@extends('web.layouts.app')
@section('title', 'Minitutor')
@section('content')
<div class="container-fluid mt-15">
  @if($minitutors->total() || request()->input('search'))
    <form method="get" class="form-search-lg">
      <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari MiniTutor..." value="{{ request()->input('search') }}">
        <span class="input-group-btn">
          <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
        </span>
      </div>
    </form>
    @foreach($minitutors as $minitutor)
      @component('web.components.minitutor_card')
        @slot('minitutor', $minitutor)
      @endcomponent
    @endforeach
    @if(!$minitutors->total())
      <div class="py-100 panel panel-body">
        <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
      </div>
    @endif
    <div class="card card-block mb-15 empty-none">
      {{ $minitutors->links() }}
    </div>
  @else
    <div class="py-100 panel panel-body">
      <h3 class="text-muted text-center">Belum ada Artikel atau Video yang di Favoritkan.</h3>
    </div>
  @endif
</div>
@endsection
