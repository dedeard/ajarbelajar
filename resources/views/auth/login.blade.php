<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="current-url" content="{{ url()->current() }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('icon/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('icon/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('icon/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('icon/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('icon/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('icon/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('icon/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('icon/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icon/apple-icon-180x180.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('icon/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('icon/favicon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="msapplication-TileImage" content="{{ asset('icon/ms-icon-144x144.png') }}">
  <meta name="msapplication-TileColor" content="#677ae4">
  <meta name="theme-color" content="#677ae4">
  <title>LOGIN | admin.ajarbelajar.com</title>
  <!-- Fonts -->
  <link rel='stylesheet' href='{{ asset('fonts/roboto/style.css') }}'>
  <link rel='stylesheet' href='{{ asset('css/theme.css') }}'>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body class="ab-auth--layout bg-light p-0">
  <header class="py-4 d-flex bg-white shadow-sm">
    <a href="/" class="d-block m-auto">
      <img src="{{ asset('img/logo/logo.svg') }}" height="40" alt="Logo Ajarbelajar" />
    </a>
  </header>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-5 col-md-8 mx-auto">
        <div class="my-4"></div>
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h2 class="text-uppercase text-center font-weight-bold text-secondary mb-3">
              {{ __('Login') }}
            </h2>
            <form method="POST" action="{{ route('login') }}" class="row">
              @csrf

              <div class="col-12">
                <div class="form-group">
                  <input placeholder="Email" name="email" type="text"
                    class="form-control @error('email') is-invalid @enderror" />
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <input placeholder="Kata Sandi" name="password" type="password"
                    class="form-control @error('password') is-invalid @enderror" />
                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <div class="checkbox-custom checkbox-primary">
                    <input type="checkbox" id="remember"
                      {{ old('remember') ? 'checked' : '' }}
                      name="remember">
                    <label for="remember">Remember me</label>
                  </div>
                </div>
              </div>

              <div class="col-12 mt-3">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary font-weight-bold btn-block btn--float">MASUK</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="ab-auth--footer bg-white border-top py-4">
    <div class="container">
      <div class="text-center font-weight-bold text-uppercase">
        &copy; Ajarbelajar 2020
      </div>
    </div>
  </footer>
</body>

</html>
