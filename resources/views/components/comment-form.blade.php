@props(['episode-id'])

<h4 class="border border-b-0 px-5 py-4 text-sm font-semibold uppercase">
  Tulis Komentar
</h4>
@auth
  <form
    x-on:submit.prevent="(e) => {
      const route = '{{ route('comments.store', $episodeId) }}'
      const body = document.getElementsByName('body')[0]
      Alpine.store('commentStore').create(route, body.value).then((ok) => ok && e.target.reset())
    }">
    <x-inputs.markdown name="body" placeholder="Tulis komentarmu disini..." />
    <div class="border-x p-3">
      <x-inputs.button X-bind:disabled="$store.commentStore.createLoading">Komentar</x-inputs.button>
    </div>
  </form>
@else
  <div class="h-32 border border-b-0 p-3">
    <p class="flex h-full flex-col items-center justify-center px-3">
      <span class="mb-3 block text-center text-xl font-light">
        Kamu harus login untuk dapat menulis komentar
      </span>
      <a href="{{ route('login') }}"
        class="select-none bg-primary-600 px-6 py-3 text-center text-sm font-semibold uppercase leading-none tracking-wider text-white hover:bg-primary-700">Login</a>
    </p>
  </div>
@endauth

