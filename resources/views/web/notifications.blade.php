@extends('web.layouts.app')
@section('content')

<div class="container-fluid mt-15">
  <div class="panel panel-bordered">
    @if($notifications->total() > 0)
    <div class="panel-heading">
      <h3 class="panel-title">{{ $notifications->total() }} Notifikasi</h3>
      <div class="panel-actions">
        <a href="{{ route('notifications.markasread') }}" class="btn btn-primary">Tandai semua Telah di baca</a>
        <a href="{{ route('notifications.destroy') }}" class="btn btn-danger">Hapus Semua</a>
      </div>
    </div>
    @endif
    <div class="panel-body">
      @if($notifications->total() > 0)
      <div class="list-group bg-blue-grey-100 bg-inherit">
        @foreach($notifications as $notification)
          <?php
            $title = "";
            $message = "";
            switch($notification->type){
              case "App\Notifications\ApproveComment":
                  $post = App\Model\Post::findOrFail($notification->data['post_id']);
                  $title = "Komentar di diterima";
                  $message = "Komentar anda pada postingan MiniTutor " . $post->user->name() . " Telah diterima.";
              break;
              case "App\Notifications\NewPost":
                  $post = App\Model\Post::findOrFail($notification->data['id']);
                  $title = "Postingan baru";
                  $message = "MiniTutor " . $post->user->name() . " Telah membagikan " . $post->type . " Baru.";
              break;
              case "App\Notifications\ApprovePost":
                  $post = App\Model\Post::findOrFail($notification->data['id']);
                  $title = "Postingan di terima";
                  $message = 'Postingan anda telah di terima "'. $post->title .'"';
              break;
              case "App\Notifications\RequestMinitutorAccepted":
                  $title = "MiniTutor diterima";
                  $message = 'Permintaan kamu untuk menjadi minitutor telah diterima';
              break;
              case "App\Notifications\RequestMinitutorRejected":
                  $title = "MiniTutor ditolak";
                  $message = 'Permintaan kamu untuk menjadi minitutor tidak diterima';
              break;
            }
          ?>
          <a class="list-group-item @if($notification->read_at) bg-white @endif" href="{{ route('notifications.read', $notification->id) }}">
            <h5 class="mt-0 mb-5">{{ $title }}</h5>
            <p class="m-0">{{ $message }}</p>
          </a>
        @endforeach
      </div>
      {{ $notifications->links() }}
      @else
      <div class="py-100">
        <h3 class="text-center"> Tidak ada Notifikasi</h3>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection