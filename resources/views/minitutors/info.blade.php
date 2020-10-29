@extends('layouts.app')

@section('content')
@component('components.minitutor_show', ['minitutor' => $minitutor])
<div class="p-3">
  <h5 class="mb-0 mt-0">Nama</h5>
  <p class="mb-2"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></p>
  <h5 class="mb-0 mt-30">Username</h5>
  <p class="mb-2">{{ $user->username }}</p>
  <h5 class="mb-0 mt-30">Email</h5>
  <p class="mb-2">{{ $user->email }}</p>
  <h5 class="mb-0 mt-30">Email di verifikasi</h5>
  <p class="mb-2">{{ $user->email_verified_at ?? 'Tidak' }}</p>

  <h5 class="mb-0 mt-30">Pedidikan terakhir</h5>
  <p class="mb-2"><strong>{{ $minitutor->last_education }}</strong></p>
  <h5 class="mb-0 mt-30">Universitas</h5>
  <p class="mb-2"><strong>{{ $minitutor->university }}</strong></p>
  <h5 class="mb-0 mt-30">Kota dan negara tempat study</h5>
  <p class="mb-2"><strong>{{ $minitutor->city_and_country_of_study }}</strong></p>
  <h5 class="mb-0 mt-30">Jurusan</h5>
  <p class="mb-2"><strong>{{ $minitutor->majors }}</strong></p>

  <h5 class="mb-0 mt-30">Spesialisasi/Minat bakat</h5>
  <p class="mb-2">{{ $minitutor->interest_talent }}</p>
  <h5 class="mb-0 mt-30">Kontak (Whatsapp)</h5>
  <p class="mb-2">{{ $minitutor->contact }}</p>
  <h5 class="mb-0 mt-30">Motivasi</h5>
  <p class="mb-2">{{ $minitutor->reason }}</p>
  <h4 class="mt-30">Ekspektasi</h4>
  <p class="mb-2">{{ $minitutor->expectation }}</p>
</div>
@endcomponent
@endsection
