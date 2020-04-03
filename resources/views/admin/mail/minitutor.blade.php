@extends('admin.layouts.app')
@section('title', 'dashboard')
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Dashboard</h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.mail.minitutor.send') }}" method="POST">
      @csrf
      <div class="form-group">
        <input type="text" name="subject" class="form-control" placeholder="Subject">
      </div>
      <div class="form-group">
        <textarea id="summernote" data-plugin="summernote" name="body">
          <h1>Hello Minitutor!</h1>
          <p>
            <span style="font-size: 1.5rem;">How's life? How do you do? Because we want to share something special for you!
            </span></p>
          <p><span style="font-size: 1.5rem;">Karena web AjarBelajar mau launching versi baru, kita mau kasih tau duluan nih ke minitutor yang udah nemenin kita sejak lama. Selain itu, ngobrol-ngobrol santai aja kita tentang AjarBelajar n beyond👍</span></p>
          <p><span style="font-size: 1.5rem;">Yuk join Zoom call kita "AjarBelajar Minitutor Meeting" di:</span></p>
          <p>
            <span style="font-size: 1.5rem;">
              📅 Sabtu, 4 April 2020 <br>
              🕗 20.00 WIB (GMT +7) <br>
              🔗 <a href="https://zoom.us/j/470457867">Link Zoom</a> <br>
            </span>
          </p>

          <p><span style="font-size: 1.5rem;">Datang dan catat waktunya ya. See you!</span></p>
        </textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
          <span class="ladda-label">Kirim</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection

