@extends('web.layouts.app')
@section('title', 'Edit data permintaan jadi Minitutor')
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
    @if ($message = Session::get('success'))
      <div class="alert alert-info alert-dismissible rounded-0" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">×</span>
          <span class="sr-only">Close</span>
        </button>
        <strong>{{ $message }}</strong>
      </div>
    @endif
    <hr class="m-0">
    <form class="panel-body" method="POST" action="{{ route('join.minitutor.update') }}">
      @csrf
      @method('put')
      <h5 class="h4">Informasi akun</h5>

      <div class="form-group @error('last_education') has-invalid @enderror">
        <label class="mb-3">Pendidikan terakhir</label>
        <select name="last_education" class="form-control select2-basic @error('last_education') is-invalid @enderror">
          <option value="" disabled>Pendidikan terakhir</option>
          @foreach($last_educations as $education)
            <option value="{{ $education }}" @if($request_minitutor->last_education === $education) selected @endif>{{ $education }}</option>
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
        <input name="university" placeholder="Nama Kampus" type="text" class="form-control @error('university') is-invalid @enderror" value="{{ $request_minitutor->university }}">
        @error('university')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">Kota dan Negara Kampus</label>
        <input name="city_and_country_of_study" placeholder="Kota dan Negara Kampus" type="text" class="form-control @error('city_and_country_of_study') is-invalid @enderror" value="{{ $request_minitutor->city_and_country_of_study }}">
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
        <input name="majors" placeholder="Jurusan" type="text" class="form-control @error('majors') is-invalid @enderror" value="{{ $request_minitutor->majors }}">
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
        <input name="interest_talent" placeholder="Spesialisasi atau Minat bakat" type="text" class="form-control @error('interest_talent') is-invalid @enderror" value="{{ $request_minitutor->interest_talent }}">
        @error('interest_talent')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">No.HP yang bisa dihubungi</label>
        <input name="contact" placeholder="No.HP yang bisa dihubungi" type="text" class="form-control @error('contact') is-invalid @enderror" value="{{ $request_minitutor->contact }}">
        @error('contact')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">Apa motivasi kamu ingin bergabung?</label>
        <textarea name="reason" placeholder="Apa motivasi kamu ingin bergabung?" class="form-control @error('reason') is-invalid @enderror">{{ $request_minitutor->reason }}</textarea>
        @error('reason')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group">
        <label class="mb-3">Ekspektasi kamu terhadap Ajarbelajar.</label>
        <textarea name="expectation" class="form-control @error('expectation') is-invalid @enderror">{{ $request_minitutor->expectation }}</textarea>
        @error('expectation')
          <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>

      <div class="form-group mt-30">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
          <span class="ladda-label">Update data</span>
        </button>
      </div>
    </form>
  </div>
</div>

@endsection
