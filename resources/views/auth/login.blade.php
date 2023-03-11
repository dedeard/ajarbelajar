<x-auth-layout title="Masuk ke akun anda">
  <x-auth.session-status :status="session('status')" />
  <form method="POST" action="{{ route('login') }}">
    @csrf
    <x-auth.input name="email" label="Alamat Email" autofocus />
    <x-auth.input type="password" name="password" label="Password" />
    @if (Route::has('password.request'))
      <div class="-mt-3 text-right">
        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">Lupa password?</a>
      </div>
    @endif
    <div class="mb-3">
      <input class="rounded shadow" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
      <label for="remember">Ingat saya</label>
    </div>
    <div class="py-3 text-center">
      <x-button value="Masuk" class="w-1/2" />
    </div>
  </form>
</x-auth-layout>
