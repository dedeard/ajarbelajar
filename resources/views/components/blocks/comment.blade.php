@props(['episode-id'])

<div x-data="{
    episodeId: {{ $episodeId }}
}" x-init="$store.commentStore.load('{{ route('comments.index', $episodeId) }}')">

  <x-blocks.comment.form :episode-id="$episodeId" />

  <template x-if="$store.commentStore.comments.length == 0">
    <div class="border p-3">
      <div class="border bg-gray-50 p-5">
        <p class="px-3 py-8 text-center text-xl font-light md:text-2xl"
          x-text="$store.commentStore.loadLoading ? 'Sedang memuat komentar' : 'Belum ada komentar'">
        </p>
      </div>
    </div>
  </template>
  <ul class="border">
    <x-blocks.comment.list x-for="comment in $store.commentStore.comments" x-bind:key="comment.id" />
  </ul>
</div>
