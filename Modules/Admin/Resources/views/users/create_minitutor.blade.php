@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">CREATE MINITUTOR</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('admin.users.minitutor.store', $user->id) }}" method="post">
          @csrf

          <div class="form-group">
            <label>Pendidikan terakhir</label>
            <select name="last_education" class="form-control @error('last_education') is-invalid @enderror">
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
            <label>Nama Kampus</label>
            <input name="university" placeholder="Nama Kampus" type="text" class="form-control @error('university') is-invalid @enderror" value="{{ old('university') }}">
            @error('university')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Kota dan Negara Kampus</label>
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
            <label>Jurusan</label>
            <input name="majors" placeholder="Jurusan" type="text" class="form-control @error('majors') is-invalid @enderror" value="{{ old('majors') }}">
            @error('majors')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>No.HP (whatsapp only)</label>
            <input name="contact" placeholder="No.HP (whatsapp only)" type="text" class="form-control @error('contact') is-invalid @enderror" value="{{ old('contact') }}">
            @error('contact')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Create Minitutor</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
