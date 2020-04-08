@extends('web.layouts.app')
@section('content')
@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  @if($users->total() || request()->input('search'))
  <form method="get" class="form-search-lg">
    <div class="input-group">
      <input type="text" class="form-control" name="search" placeholder="Cari Pengguna yang mengikuti kamu.." value="{{ request()->input('search') }}">
      <span class="input-group-btn">
        <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
      </span>
    </div>
  </form>
  <div class="row">
    @foreach($users as $user)
    <div class="col-lg-6">
      @component('web.components.user-card')
        @slot('user', $user)
      @endcomponent
    </div>
    @endforeach
  </div>
  @if(!$users->total())
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Tidak ada hasil pencarian untuk "{{ request()->input('search') }}"</h3>
  </div>
  @endif
  <div class="card card-block mb-15 empty-none">
    {{ $users->links() }}
  </div>
  @else
  <div class="py-100 panel panel-body">
    <h3 class="text-muted text-center">Kamu belum mempunyai pengikut.</h3>
  </div>
  @endif
</div>
@endcomponent
@endsection