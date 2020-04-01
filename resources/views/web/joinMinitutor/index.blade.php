@extends('web.layouts.app')
@section('content')

<div class="container-fluid my-15">
  <div class="card card-inverse card-shadow cover white">
    <div class="cover-background" style="background-image: url({{ asset('img/background/people-team.jpg') }})">
      <div class="card-block p-30 py-lg-80 overlay-background text-center">
        <h1 class="display-4 text-white text-shadow">
          Belajar, Berbagi, Berkontribusi.
        </h1>
        <p class="lead text-white text-shadow">
          Pengembangan kemampuan diri dan kualitas pendidikan Indonesia,
          dimulai dari sini!
        </p>
        @if(Auth::user() && Auth::user()->requestMinitutor)
        <a href="{{ route('join.minitutor.edit') }}" class="btn btn-primary">
          EDIT DATA PERMINTAAN ANDA
        </a>
        @else
        <a href="{{ route('join.minitutor.create') }}" class="btn btn-primary" rel="nofollow">
          GABUNG SEKARANG
        </a>
        @endif
      </div>
    </div>
  </div>

  <div class="card card-block">
    <h3 class="h1 font-weight-normal text-center">
      Beragam, dan akan terus bertumbuh!
    </h3>
    <p class="lead text-center">
      AjarBelajar diisi oleh konten dari MiniTutor dengan berbagai macam latar
      belakang. Ada banyak bidang ilmu dan topik bahasan yang bisa disimak,
      dan akan terus bertambah.
    </p>
    <div class="row my-15">
      <div class="col-lg-4">
        <div class="card p-30 bg-grey-100 flex-row justify-content-between">
          <div class="white">
            <i class="icon icon-circle icon-2x wb-user-circle bg-red-600"></i>
          </div>
          <div class="counter counter-md counter text-right">
            <div class="counter-number-group">
              <span class="counter-number">{{ $user_count }}</span>
              <span class="counter-number-related text-capitalize">Pengguna</span>
            </div>
            <div class="counter-label text-capitalize font-size-16">Terdaftar</div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card p-30 bg-grey-100 flex-row justify-content-between">
          <div class="white">
            <i class="icon icon-circle icon-2x wb-users bg-blue-600"></i>
          </div>
          <div class="counter counter-md counter text-right">
            <div class="counter-number-group">
              <span class="counter-number">{{ $minitutor_count }}</span>
              <span class="counter-number-related text-capitalize">Minitutor</span>
            </div>
            <div class="counter-label text-capitalize font-size-16">Berkontribusi</div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card p-30 bg-grey-100 flex-row justify-content-between">
          <div class="white">
            <i class="icon icon-circle icon-2x wb-clipboard bg-green-600"></i>
          </div>
          <div class="counter counter-md counter text-right">
            <div class="counter-number-group">
              <span class="counter-number">{{ $post_count }}</span>
              <span class="counter-number-related text-capitalize">Postingan</span>
            </div>
            <div class="counter-label text-capitalize font-size-16">Terbit</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
