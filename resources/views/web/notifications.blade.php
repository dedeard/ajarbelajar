@extends('web.layouts.app')
@section('content')

<div class="container-fluid mt-15">
  <div class="panel panel-bordered">
    @if($notifications->total() > 0)
    <div class="panel-heading">
      <h3 class="panel-title">{{ $notifications->total() }} Notifikasi</h3>
      <div class="panel-actions">
        <a href="{{ route('notifications.markasread') }}" class="btn btn-primary">Tandai semua telah di baca</a>
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
                  $post = App\Models\Post::find($notification->data['post_id']);
                  $title = "Komentar diterima";
                  if($post) {
                    $message = "Komentar anda pada postingan MiniTutor " . $post->user->name() . " telah diterima.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\CommentToMinitutorPost":
                $post = App\Models\Post::find($notification->data['post_id']);
                $comment = App\Models\PostComment::find($notification->data['comment_id']);
                $title = "Postingan dikomentari";
                if($post && $comment) {
                  $message = $comment->user->name() . " mengomentari " . $post->type . " anda.";
                } else {
                  $message = "Postingan ini tidak tersedia lagi.";
                }
              break;
              case "App\Notifications\NewPost":
                  $post = App\Models\Post::find($notification->data['id']);
                  $title = "Postingan baru";
                  if($post) {
                    $message = "MiniTutor " . $post->user->name() . " telah membagikan " . $post->type . " baru.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\PostUpdated":
                  $post = App\Models\Post::find($notification->data['id']);
                  $title = "Postingan diperbarui";
                  if($post) {
                    $message = "Konten kamu telah diperbarui.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\ApprovePost":
                  $post = App\Models\Post::find($notification->data['id']);
                  $title = "Postingan di terima";
                  if($post) {
                    $message = 'Postingan anda telah diterima "'. $post->title .'"';
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\RequestMinitutorAccepted":
                  $title = "MiniTutor diterima";
                  $message = 'Permintaan kamu untuk menjadi MiniTutor telah diterima';
              break;
              case "App\Notifications\RequestMinitutorRejected":
                  $title = "MiniTutor ditolak";
                  $message = 'Permintaan kamu untuk menjadi MiniTutor tidak diterima';
              break;
              case "App\Notifications\ReviewToMinitutorPost":
                $postReview = App\Models\PostReview::find($notification->data['review_id']);
                $title = "Feedback";
                if($postReview) {
                  $message = $postReview->user->name() . ' telah memberikan feedback pada konten kamu.';
                } else {
                  $message = "Feedback ini tidak tersedia lagi.";
                }
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
        <h3 class="text-center"> Tidak ada notifikasi</h3>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection
