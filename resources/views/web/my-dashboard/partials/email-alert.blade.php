<div class="container-fluid">
  @if(Auth::user()->email_verified_at === null)
  <div class="alert alert-warning text-center shadow-sm">
    Alamat Email Anda belum di Verifikasi. silahkan cek email anda kemudian klik link Verifikasinya, <br>
    Jika anda belum menerima email Verifikasinya silahkan klik <a href="{{ route('verification.notice') }}" class="">Disini</a>
  </div>
  @endif
</div>