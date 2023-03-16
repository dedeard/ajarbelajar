<ul>
  @foreach ($comments as $comment)
    <livewire:comment-list :key="$comment->id" :comment="$comment" :user="$user" />
  @endforeach
</ul>
