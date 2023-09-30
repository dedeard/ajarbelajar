@props(['episode-id'])

<div x-data="{
    episodeId: {{ $episodeId }}
}" x-init="$store.commentStore.load('{{ route('comments.index', $episodeId) }}')">

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
      <x-input.markdown name="body" placeholder="Tulis komentarmu disini..." />
      <div class="border-x p-3">
        <x-input.button X-bind:disabled="$store.commentStore.createLoading">Komentar</x-input.button>
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

  <template x-if="$store.commentStore.comments.length == 0">
    <div class="p-3">
      <div class="border bg-gray-50 p-5">
        <p class="px-3 py-8 text-center text-xl font-light md:text-2xl"
          x-text="$store.commentStore.loadLoading ? 'Sedang memuat komentar' : 'Belum ada komentar'">
        </p>
      </div>
    </div>
  </template>
  <ul class="border">
    <template x-for="comment in $store.commentStore.comments" x-bind:key="comment.id">
      <li class="flex px-3 py-5 odd:bg-gray-50">
        <div class="pr-3">
          <a x-bind:href="'/users/' + comment.user.username" class="block h-10 w-10 rounded-full border">
            <template x-if="comment.user.avatar_url">
              <img x-bind:src="comment.user.avatar_url" x-bind:alt="comment.user.name" class="block h-full w-full rounded-full" />
            </template>
            <template x-if="!comment.user.avatar_url" x-data="{ name: comment.user.name }">
              <x-avatar alpine class="block h-full w-full rounded-full" />
            </template>
          </a>
        </div>
        <div class="flex-1">
          <div class="mb-3 flex h-10 flex-col justify-center">
            <a x-bind:href="'/users/' + comment.user.username" class="block text-sm font-semibold capitalize text-primary-600"
              x-text='comment.user.name'></a>
            <span class="block text-xs" x-text="comment.time_ago"></span>
          </div>
          <div class='prose mb-3 max-w-none' x-html='comment.html_body'></div>
          @auth
            <div class="flex">
              <div>
                <button x-bind:class="{ 'text-red-600': comment.liked }" X-bind:disabled="$store.commentStore.likeLoading"
                  x-on:click="$store.commentStore.likeToggle('{{ route('comments.like-toggle', '__id__') }}'.replace('__id__', comment.id), comment.id)">
                  <i class="ft ft-heart"></i>
                  <span x-text="comment.like_count"></span></button>
              </div>
              <div class="ml-auto">
                <template x-if="$store.authStore.auth.id === comment.user.id">
                  <button class="text-red-600" X-bind:disabled="$store.commentStore.destroyLoading"
                    x-on:click="$store.deleteConfirm(() => $store.commentStore.destroy('{{ route('comments.destroy', '__id__') }}'.replace('__id__', comment.id), comment.id))">
                    <i class="ft ft-trash"></i>
                  </button>
                </template>
              </div>
            </div>
          @endauth
        </div>
      </li>
    </template>
  </ul>
</div>
