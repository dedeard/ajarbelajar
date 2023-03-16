<li class="flex px-3 py-5 odd:bg-gray-50">
  <div class="pr-3">
    <a href="{{ route('users.show', $comment->user->username) }}" class="block h-10 w-10 rounded-full border">
      <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="block w-full rounded-full" />
    </a>
  </div>

  <div class="flex-1">
    <div class="mb-3 flex h-10 flex-col justify-center">
      <a href="{{ route('users.show', $comment->user->username) }}" class="block text-sm font-semibold capitalize text-primary-600">
        {{ $comment->user->name }}
      </a>
      <span class="block text-xs">{{ $comment->created_at->diffFOrHumans() }}</span>
    </div>
    <div class="prose mb-3 max-w-none">
      {!! $comment->html_body !!}
    </div>
    <div class="flex justify-end">
      @if ($user && $user->id === $comment->user->id)
        <button x-data="{
            async submit() {
                try {
                    await window.axios.delete('{{ route('comments.delete', $comment->id) }}')
                    if (typeof window.EDJS?.clear === 'function') window.EDJS.clear()
                    window.fire.success('Berhasil menghapus komentar')
                    Livewire.emit('comment-deleted')
                } catch (e) {
                    window.fire.error(e.response?.data.message || e.message)
                }
            }
        }" x-on:click="() => $store.deleteConfirm(submit)" type="button"
          class="mr-6 flex items-center justify-center leading-none text-red-600 hover:text-red-700">
          Hapus
        </button>
      @endif
      <button class="@if ($comment->liked()) text-red-600 @endif flex items-center justify-center leading-none" type="button"
        wire:click="likeToggle" @guest disabled @endguest>
        <span class="block">
          <x-svg.heart width="20" height="20" fill="currentColor" />
        </span>
        <span class="ml-1 block">{{ $comment->likeCount }}</span>
      </button>
    </div>
  </div>
</li>
