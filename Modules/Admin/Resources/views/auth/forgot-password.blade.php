<x-admin::layouts.auth title="Lupa Password">
  <p class="login-box-msg">Anda lupa kata sandi Anda? Di sini Anda dapat dengan
    mudah mengambil kata sandi baru</p>
  @if ($status = session('status'))
    <div class="alert alert-primary" role="alert">
      {{ $status }}
    </div>
  @endif
  <form action="{{ route('admin.password.email') }}" method="post">
    @csrf
    <x-admin::input name="email" label="Email" />
    <div class="row">
      <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
      </div>
    </div>
  </form>
  <hr />
  <p class="mb-1 text-center">
    <a href="{{ route('admin.login') }}">Masuk</a>
  </p>
</x-admin::layouts.auth>
