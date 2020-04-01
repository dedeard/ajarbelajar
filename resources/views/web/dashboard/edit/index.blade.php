@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')
<div class="panel rounded-0 rounded-bottom">
  <div class="panel-body">
    <form class="row" action="{{ route('dashboard.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('put')
      <div class="col-lg-3 mb-30">
        <div id="avatar-uploader" class="ab-dashboard__avatar-uploader">
          <span class="avatar img-bordered bg-light">
            <img src="{{ Auth::user()->imageUrl() }}" alt="{{ Auth::user()->username }}">
          </span>
          <button class="btn btn-light btn-sm btn-floating" data-toggle="avatar-uploader" data-target="#input-avatar"><i class="icon wb-image"></i></button>
          <input type="file" name="image" class="ab-dashboard__avatar-uploader-input" id="input-avatar">
          <p class="file-name text-truncate"></p>
        </div>
        @error('image')
          <div class="text-center text-danger">
            <strong>{{ $message }}</strong>
          </div>
        @enderror
      </div>
      <div class="col-lg-9">

        <!-- Account :start -->
        <h5 class="h4">Informasi akun</h5>

        <div class="form-group">
          <label class="mb-3">Nama Pengguna</label>
          <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Nama Pengguna" value="{{ Auth::user()->username }}">
          @error('username')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Alamat Email</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Alamat Email" value="{{ Auth::user()->email }}">
          @error('email')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <!-- Account :end -->

        <hr class="my-4">

        <!-- User Passsword :start -->
        <h5 class="h4">Ubah Kata Sandi </h5>
        <p>Kosongkan jika Tidak ingin diubah.</p>

        <div class="row">
          <div class="form-group col-md-6">
            <label class="mb-3">Kata Sandi Baru</label>
            <input type="text" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="Kata Sandi Baru">
            @error('new_password')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label class="mb-3">Konfirmasi Kata Sandi Baru</label>
            <input type="text" class="form-control @error('c_new_password') is-invalid @enderror" name="c_new_password" placeholder="Konfirmasi Kata Sandi Baru">
          </div>
        </div>

        <div class="form-group">
          <label class="mb-3">Kata Sandi</label>
          <input type="text" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Kata Sandi">
          @error('password')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <!-- User Passsword :end -->

        <hr class="my-4">

        <!-- User Profile :start -->
        <h5 class="h4">Profil</h5>

        <div class="row">
          <div class="form-group col-md-6">
            <label class="mb-3">Nama Depan</label>
            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Nama Depan" value="{{ Auth::user()->first_name }}">
            @error('first_name')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label class="mb-3">Nama Belakang</label>
            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Nama Belakang" value="{{ Auth::user()->last_name }}">
            @error('last_name')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
        </div>
        
        <div class="form-group">
          <div class="form-group">
            <label class="mb-3">Tentang</label>
            <textarea class="form-control @error('about') is-invalid @enderror" name="about" placeholder="Tentang">{{ Auth::user()->about }}</textarea>
            @error('about')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label class="mb-3">Website</label>
          <input type="text" class="form-control @error('website_url') is-invalid @enderror" name="website_url" placeholder="Website" value="{{ Auth::user()->website_url }}">
          @error('website_url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @else
            <span class="text-help">Contoh: https://ajarbelajar.com</span>
          @enderror
        </div>
        <!-- User Profile :end -->

        <hr class="my-4">

        <!-- User Socials :start -->
        <h5 class="h4">Media Sosial</h5>

        <div class="form-group">
          <label class="mb-3">Facebook</label>
          <input type="text" class="form-control @error('facebook_url') is-invalid @enderror" name="facebook_url" placeholder="Facebook" value="{{ Auth::user()->facebook_url }}">
          @error('facebook_url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @else
            <span class="text-help">Contoh: https://facebook.com/username</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Instagram</label>
          <input type="text" class="form-control @error('instagram_url') is-invalid @enderror" name="instagram_url" placeholder="Instagram" value="{{ Auth::user()->instagram_url }}">
          @error('instagram_url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @else
            <span class="text-help">Contoh: https://instagram.com/username</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Twitter</label>
          <input type="text" class="form-control @error('twitter_url') is-invalid @enderror" name="twitter_url" placeholder="Twitter" value="{{ Auth::user()->twitter_url }}">
          @error('twitter_url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @else
            <span class="text-help">Contoh: https://twitter.com/username</span>
          @enderror
        </div>

        <div class="form-group">
          <label class="mb-3">Youtube</label>
          <input type="text" class="form-control @error('youtube_url') is-invalid @enderror" name="youtube_url" placeholder="Youtube" value="{{ Auth::user()->youtube_url }}">
          @error('youtube_url')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
          @else
            <span class="text-help">Contoh: https://youtube.com/channel/channel_id</span>
          @enderror
        </div>
        <!-- User Socials :end -->

        <div class="form-group mt-30">
          <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
            <span class="ladda-label">Simpan</span>
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endcomponent
@endsection
