<x-auth-layout title="Konfirmasi Password">
  <x-auth.message>
    Ini adalah area aman pada aplikasi. Harap konfirmasi password anda sebelum
    melanjutkan.
  </x-auth.message>
  <form method="POST" action="{{ route('password.confirm') }}">
    @csrf
    <x-auth.input type="password" name="password" label="Password" autofocus />
    <div class="py-3 text-center">
      <x-auth.button value="Konfirmasi" />
    </div>
  </form>
  <hr>
  <form method="POST" action="{{ route('logout') }}" class="text-center">
    @csrf
    <div class="py-3 text-center">
      <x-auth.button value="Keluar" variant="red" />
    </div>
  </form>
</x-auth-layout>
