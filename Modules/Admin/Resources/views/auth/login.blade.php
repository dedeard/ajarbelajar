<x-admin::layouts.auth>
  <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>
  @if ($status = session('status'))
    <div class="alert alert-primary" role="alert">
      {{ $status }}
    </div>
  @endif
  <form action="{{ route('admin.login') }}" method="post">
    @csrf
    <x-admin::input name="email" label="Email" />
    <x-admin::input name="password" label="Password" type="password" />

    <div class="row">
      <div class="col-8">
        <x-admin::checkbox name="remember" label="Ingat saya"
          :checked="old('remember')" />
      </div>
      <div class="col-4">
        <button type="submit" class="btn btn-primary btn-block">Masuk</button>
      </div>
    </div>
  </form>
  <hr />
  <p class="mb-1 text-center">
    <a href="{{ route('admin.password.request') }}">Lupa password?</a>
  </p>
</x-admin::layouts.auth>
