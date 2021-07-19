<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <x-head></x-head>
  @yield('style:before')
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('style:after')
</head>


<body class="bg-light d-flex flex-column" style="min-height: 100vh">
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
                  <input placeholder="Email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" />
                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <input placeholder="Kata Sandi" name="password" type="password" class="form-control @error('password') is-invalid @enderror" />
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
                    <input type="checkbox" id="remember" {{ old('remember') ? 'checked' : '' }} name="remember">
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
  <footer class="bg-white border-top py-4 mt-auto">
    <div class="container">
      <div class="text-center font-weight-bold text-uppercase">
        &copy; Ajarbelajar 2020
      </div>
    </div>
  </footer>
</body>

</html>
