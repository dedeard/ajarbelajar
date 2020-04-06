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
                  $post = App\Model\Post::find($notification->data['post_id']);
                  $title = "Komentar di diterima";
                  if($post) {
                    $message = "Komentar anda pada postingan MiniTutor " . $post->user->name() . " Telah diterima.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\CommentToMinitutorPost":
                $post = App\Model\Post::find($notification->data['post_id']);
                $comment = App\Model\PostComment::find($notification->data['comment_id']);
                $title = "Postingan dikomentari";
                if($post && $comment) {
                  $message = $comment->user->name() . " Mengomentari " . $post->type . " Anda.";
                } else {
                  $message = "Postingan ini tidak tersedia lagi.";
                }
              break;
              case "App\Notifications\NewPost":
                  $post = App\Model\Post::find($notification->data['id']);
                  $title = "Postingan baru";
                  if($post) {
                    $message = "MiniTutor " . $post->user->name() . " Telah membagikan " . $post->type . " Baru.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\PostUpdated":
                  $post = App\Model\Post::find($notification->data['id']);
                  $title = "Postingan diedit";
                  if($post) {
                    $message = "Kontent kamu telah diedit.";
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\ApprovePost":
                  $post = App\Model\Post::find($notification->data['id']);
                  $title = "Postingan di terima";
                  if($post) {
                    $message = 'Postingan anda telah di terima "'. $post->title .'"';
                  } else {
                    $message = "Postingan ini tidak tersedia lagi.";
                  }
              break;
              case "App\Notifications\RequestMinitutorAccepted":
                  $title = "MiniTutor diterima";
                  $message = 'Permintaan kamu untuk menjadi minitutor telah diterima';
              break;
              case "App\Notifications\RequestMinitutorRejected":
                  $title = "MiniTutor ditolak";
                  $message = 'Permintaan kamu untuk menjadi minitutor tidak diterima';
              break;
              case "App\Notifications\ReviewToMinitutorPost":
                $postReview = App\Model\PostReview::find($notification->data['review_id']);
                $title = "Feedback";
                if($postReview) {
                  $message = $postReview->user->name() . ' telah memberikan feedback pada kontent kamu.';
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
        <h3 class="text-center"> Tidak ada Notifikasi</h3>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection