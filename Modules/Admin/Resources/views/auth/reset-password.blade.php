<x-admin::layouts.auth title="Reset Password">
  <p class="login-box-msg">Anda hanya selangkah lagi dari kata sandi baru Anda,
    pulihkan kata sandi
    Anda sekarang.</p>
  <form method="POST" action="{{ route('admin.password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <x-admin::input name="email" label="Email" :value="old('email', $request->email)" />
    <x-admin::input name="password" label="Password Baru" type="password" />

    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">Atur ulang
          Password</button>
      </div>
    </div>
  </form>
  <hr />
  <p class="mb-1 text-center">
    <a href="{{ route('admin.login') }}">Masuk</a>
  </p>
</x-admin::layouts.auth>
