@extends('web.layouts.app')
@section('content')
@component('web.minitutor.components.layout')
@slot('minitutor', $minitutor)



<div class="panel panel-body minitutor-info-panel">
  <span>Nama Lengkap</span>
  <p class="name">{{ $minitutor->user->name() }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Jurusan</span>
  <p class="name">{{ $minitutor->majors }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Jenjang</span>
  <p class="name">{{ $minitutor->last_education }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Nama Kampus</span>
  <p class="name">{{ $minitutor->university }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Alamat Kampus</span>
  <p class="name">{{ $minitutor->city_and_country_of_study }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Minat dan Bakat</span>
  <p class="name">{{ $minitutor->interest_talent }}</p>
</div>

<div class="panel panel-body minitutor-info-panel">
  <span>Tentang</span>
  <p class="name">{{ $minitutor->user->about ?? '-' }}</p>
</div>

@endcomponent
@endsection