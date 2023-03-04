<x-auth-layout title="Lupa Password">
  <x-auth.message>
    Lupa password Anda? Tidak masalah.
    Beri tahu kami alamat email Anda dan kami akan mengirimkan email
    berisi tautan pengaturan ulang
    password yang memungkinkan Anda memilih password yang baru.
  </x-auth.message>
  <x-auth.session-status :status="session('status')" />
  <form method="POST" action="{{ route('password.email') }}">
    @csrf
    <x-auth.input name="email" label="Alamat Email" autofocus />
    <div class="py-3 text-center">
      <x-button value="Kirim" class="w-1/2" />
    </div>
  </form>
  <div class="mt-3 text-center">
    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">Kembali ke halaman login</a>
  </div>
</x-auth-layout>
