@extends('web.layouts.app')
@section('content')

<div class="container-fluid my-15">
  <div class="join-minitutor-card" style="background-image: url({{ asset('img/background/people-team.jpg') }})">
    <div class="join-minitutor-card_filter">
      <div class="join-minitutor-card_content">
        <h1 class="display-4 text-white text-shadow">Belajar, Berbagi, Berkontribusi.</h1>
        <p class="lead text-white text-shadow">Pengembangan kemampuan diri dan kualitas pendidikan Indonesia, dimulai dari sini!</p>
        @if(Auth::user() && Auth::user()->requestMinitutor)
        <a rel="nofollow" href="{{ route('join.minitutor.edit') }}" class="btn btn-primary">
          EDIT DATA PERMINTAAN ANDA
        </a>
        @else
        <a rel="nofollow" href="{{ route('join.minitutor.create') }}" class="btn btn-primary">
          GABUNG SEKARANG
        </a>
        @endif
      </div>
    </div>
  </div>




  @include('web.partials.post-user-minitutor-count')
</div>
@endsection
