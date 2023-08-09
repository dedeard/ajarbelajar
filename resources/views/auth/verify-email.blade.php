<x-auth-layout title="Verifikasi Email">
  <x-auth.message>
    Terima kasih sudah mendaftar! Sebelum memulai, bisa kah Anda memverifikasi
    alamat email dengan mengklik tautan yang kami kirim? Jika
    Anda tidak menerima email, kami akan mengirim ulang. </x-auth.message>
  @if (session('status') == 'verification-link-sent')
    <x-auth.session-status
      status="Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran." />
  @endif
  <form method="POST" action="{{ route('verification.send') }}">
    @csrf
    <div class="py-3 text-center">
      <x-button value="Kirim ulang email verifikasi" class="w-[60%]" />
    </div>
  </form>
  <hr>
  <form method="POST" action="{{ route('logout') }}" class="text-center">
    @csrf
    <div class="py-3 text-center">
      <x-button value="Keluar" class="w-[60%]" variant="red" />
    </div>
  </form>
</x-auth-layout>
