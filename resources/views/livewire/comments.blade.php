<div>
  @if (!count($comments))
    <div class="p-3">
      <div class="border bg-gray-50 p-5">
        <p class="px-3 py-8 text-center text-xl font-light md:text-2xl">BELUM ADA
          KOMENTAR</p>
      </div>
    </div>
  @else
    <ul>
      @foreach ($comments as $comment)
        <livewire:comment-list :key="$comment->id" :comment="$comment"
          :user="$user" />
      @endforeach
    </ul>
  @endif
</div>
