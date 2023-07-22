<div>
  @if(!count($comments))
  <div class="p-3">
    <div class="border p-5 bg-gray-50">
      <p class="text-center text-xl px-3 py-8 md:text-2xl font-light">BELUM ADA KOMENTAR</p>
    </div>
  </div>
  @else
  <ul>
    @foreach ($comments as $comment)
    <livewire:comment-list :key="$comment->id" :comment="$comment" :user="$user" />
    @endforeach
  </ul>
  @endif
</div>