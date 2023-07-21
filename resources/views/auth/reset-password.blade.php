<x-auth-layout title="Reset Password">
  <form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <x-auth.input name="email" label="Alamat Email" :value="old('email', $request->email)" autofocus />
    <x-auth.input type="password" name="password" label="Password" />
    <div class="py-3 text-center">
      <x-button value="Atur ulang Password" class="w-1/2" />
    </div>
  </form>
  <div class="mt-3 text-center">
    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">Kembali ke halaman login</a>
  </div>
</x-auth-layout>