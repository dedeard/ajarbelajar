@extends('web.layouts.app')
@section('content')
<div class="container-fluid">

  <div class="panel mt-15">
    <div class="panel-body">
      <h2 class="text-center">
        Input Sesuai Data Diri Anda.
      </h2>
      <p class="text-center">
        Nama, Alamat Email, Media Sosial dan Foto secara otomatis ikut dalam formulir Anda sesuai dengan profil akun Anda.
      </p>
    </div>
    <hr class="m-0">
    <form class="panel-body" method="POST" action="{{ route('join.minitutor.store') }}">
      @csrf
      <h5 class="h4">Informasi akun</h5>

      <div class="form-group @error('last_education') has-invalid @enderror">
        <label class="mb-3">Pendidikan terakhir</label>
        <select name="last_education" class="form-control @error('last_education') is-invalid @enderror"
        >
          <option value="" disabled @if(!old('last_education')) selected @endif>Pendidikan terakhir</option>
          @foreach($last_educations as $education)
          <option value="{{ $education }}" @if(old('last_education') === $education) selected @endif>{{ $education }}</option>
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
        <input name="university" placeholder="Nama Kampus" type="text" class="form-control @error('university') is-invalid @enderror" value="{{ old('university') }}">
        @error('university')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">Kota dan Negara Kampus</label>
        <input name="city_and_country_of_study" placeholder="Kota dan Negara Kampus" type="text" class="form-control @error('city_and_country_of_study') is-invalid @enderror" value="{{ old('city_and_country_of_study') }}">
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
        <input name="majors" placeholder="Jurusan" type="text" class="form-control @error('majors') is-invalid @enderror" value="{{ old('majors') }}">
        @error('majors')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <hr class="my-4" />

      <h5 class="h4">Tentang anda</h5>

      <div class="form-group">
        <label class="mb-3">Spesialisasi atau Minat bakat</label>
        <input name="interest_talent" placeholder="Spesialisasi atau Minat bakat" type="text" class="form-control @error('interest_talent') is-invalid @enderror" value="{{ old('interest_talent') }}">
        @error('interest_talent')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">No.HP (whatsapp only)</label>
        <input name="contact" placeholder="No.HP (whatsapp only)" type="text" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}">
        @error('contact')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <div class="checkbox-custom checkbox-primary">
          <input type="checkbox" id="join-group-check" name="join_group">
          <label for="join-group-check">Apakah anda ingin dimasukan ke group whatsapp.</label>
        </div>
      </div>

      <div class="form-group">
        <label class="mb-3">Apa motivasi kamu ingin bergabung?</label>
        <textarea name="reason" placeholder="Apa motivasi kamu ingin bergabung?" class="form-control @error('reason') is-invalid @enderror">{{ old('reason') }}</textarea>
        @error('reason')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">Ekspektasi kamu terhadap Ajarbelajar.</label>
        <textarea name="expectation" class="form-control @error('expectation') is-invalid @enderror">{{ old('expectation') }}</textarea>
        @error('expectation')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group mt-30">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
          <span class="ladda-label">Kirim data</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
