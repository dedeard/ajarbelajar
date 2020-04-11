@extends('admin.layouts.app')
@section('title', 'Permintaan Minitutor')
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Data Permintaan Menjadi MiniTutor</h3>
    <div class="panel-actions">
      <button class="btn btn-success" onclick="$('#form-accept-request').submit()">Terima</button>
      <button class="btn btn-danger" onclick="$('#form-reject-request').submit()">Tolak</button>

      <form action="{{ route('admin.minitutor.request.reject', $data['id']) }}" id="form-reject-request" method="post" class="d-none">
        @csrf
        @method('put')
      </form>
      <form action="{{ route('admin.minitutor.request.accept', $data['id']) }}" id="form-accept-request" method="post" class="d-none">
        @csrf
        @method('put')
      </form>
    </div>
  </div>
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-2 col-md-4 mb-30">
        <a href="#show-activity" class="avatar avatar-100">
          <img alt="photo" src="{{ $data->user->imageUrl() }}">
        </a>
      </div>
      <div class="col-lg-10 col-md-6 mb-3">
        <h4 class="mt-0">Nama</h4>
        <p class="mb-30"><a class="kt-link" href="#show-activity">{{ $data->user->name() }}</a></p>
        <h4 class="mt-30">Username</h4>
        <p class="mb-30">{{ $data->user->username }}</p>
        <h4 class="mt-30">Email</h4>
        <p class="mb-30">{{ $data->user->email }}</p>
        <h4 class="mt-30">Email di verifikasi</h4>
        <p class="mb-30">{{ $data->user->email_verified_at ?? 'Tidak' }}</p>

        <h4 class="mt-30">Pedidikan terakhir</h4>
        <p class="mb-30"><strong>{{ $data->last_education }}</strong></p>
        <h4 class="mt-30">Universitas</h4>
        <p class="mb-30"><strong>{{ $data->university }}</strong></p>
        <h4 class="mt-30">Kota dan negara tempat study</h4>
        <p class="mb-30"><strong>{{ $data->city_and_country_of_study }}</strong></p>
        <h4 class="mt-30">Jurusan</h4>
        <p class="mb-30"><strong>{{ $data->majors }}</strong></p>

        <h4 class="mt-30">Spesialisasi/Minat bakat</h4>
        <p class="mb-30">{{ $data->interest_talent }}</p>
        <h4 class="mt-30">Kontak (Whatsapp)</h4>
        <p class="mb-30">{{ $data->contact }} @if($data->join_group) (tambahkan ke group whatsapp minitutor jika diterima) @endif </p>
        <h4 class="mt-30">Motivasi</h4>
        <p class="mb-30">{{ $data->reason }}</p>
        <h4 class="mt-30">Ekspektasi</h4>
        <p class="mb-30">{{ $data->expectation }}</p>

      </div>
    </div>
  </div>
</div>
@endsection