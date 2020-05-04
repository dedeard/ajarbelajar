@extends('web.layouts.app')
@section('content')


@component('web.minitutor-dashboard.components.layout-wrapper')
<div class="container-fluid">
  <div class="panel">
    <div class="panel-body">
      <form action="{{ route('dashboard.minitutor.edit.update') }}" method="post">
        @csrf
        @method('put')
        <h5 class="h4">Informasi Pendidikan</h5>

        <div class="form-group @error('last_education') has-invalid @enderror">
          <label class="mb-3">Pendidikan terakhir</label>
          <select name="last_education" class="form-control select2-basic @error('last_education') is-invalid @enderror">
            <option value="" disabled>Pendidikan terakhir</option>
            @foreach($last_educations as $education)
            <option value="{{ $education }}" @if(Auth::user()->minitutor->last_education === $education) selected @endif>{{ $education }}</option>
            @endforeach
          </select>
          @error('last_education')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Nama Kampus</label>
          <input name="university" placeholder="Nama Kampus" type="text" class="form-control @error('university') is-invalid @enderror" value="{{ Auth::user()->minitutor->university }}">
          @error('university')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Kota dan Negara Kampus</label>
          <input name="city_and_country_of_study" placeholder="Kota dan Negara Kampus" type="text" class="form-control @error('city_and_country_of_study') is-invalid @enderror" value="{{ Auth::user()->minitutor->city_and_country_of_study }}">
          @error('city_and_country_of_study')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @else
          <span class="text-help">Contoh: Jakatarta, Indonesia</span>
          @enderror
        </div>


        <div class="form-group">
          <label class="mb-3">Jurusan</label>
          <input name="majors" placeholder="Jurusan" type="text" class="form-control @error('majors') is-invalid @enderror" value="{{ Auth::user()->minitutor->majors }}">
          @error('majors')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Spesialisasi atau minat bakat</label>
          <input name="interest_talent" placeholder="Spesialisasi atau Minat bakat" type="text" class="form-control @error('interest_talent') is-invalid @enderror" value="{{ Auth::user()->minitutor->interest_talent }}">
          @error('interest_talent')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <hr class="my-4" />

        <h5 class="h4">Tentang anda</h5>
        <p><strong>Semua data dibawah, tidak ditampilkan ke publik.</strong></p>

        <div class="form-group">
          <label class="mb-3">No.HP yang bisa dihubungi</label>
          <input name="contact" placeholder="No.HP yang bisa dihubungi" type="text" class="form-control @error('contact') is-invalid @enderror" value="{{ Auth::user()->minitutor->contact }}">
          @error('contact')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Apa motivasi kamu ingin bergabung?</label>
          <textarea name="reason" placeholder="Apa motivasi kamu ingin bergabung?" class="form-control @error('reason') is-invalid @enderror">{{ Auth::user()->minitutor->reason }}</textarea>
          @error('reason')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Ekspektasi kamu terhadap AjarBelajar.</label>
          <textarea name="expectation" class="form-control @error('expectation') is-invalid @enderror">{{ Auth::user()->minitutor->expectation }}</textarea>
          @error('expectation')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
          @enderror
        </div>

        <div class="form-group mt-30">
          <button type="submit" class="btn btn-primary">Update data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endcomponent

@endsection