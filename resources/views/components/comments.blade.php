@props(['episode-id'])

<div x-data="{
    episodeId: {{ $episodeId }},
    loading: true,
    comments: [],
    error: '',
    async loadComments() {
        try {
            this.comments = (await window.axios.get(`/comments/${this.episodeId}`)).data;
        } catch (e) {
            this.error = e.response?.data.message || e.message
            window.fire.error(this.error)
        }
        this.loading = false
    }
}" x-init="loadComments">

  @auth
    <form x-data="{
        async submit(e) {
            const bodyEl = document.getElementsByName('body')[0]
            try {
                const comment = (await window.axios.post('{{ route('comments.store', $episodeId) }}', { body: bodyEl.value })).data
                window.fire.success('Berhasil membuat komentar')
                this.comments = [comment, ...this.comments]
                e.target.reset()
            } catch (e) {
                window.fire.error(e.response?.data.message || e.message)
            }
        }
    }" x-on:submit.prevent="submit">
      <h4 class="border-b px-5 py-4 text-sm font-semibold uppercase">
        Tulis Komentar
      </h4>
      <div class="border-b">
        <x-form.markdown name="body" :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
      </div>
      <div class="border-b p-3">
        <x-button>Komentar</x-button>
      </div>
      <div>
    </form>
  @endauth

  <template x-if="comments.length == 0">
    <div class="p-3">
      <div class="border bg-gray-50 p-5">
        <p class="px-3 py-8 text-center text-xl font-light md:text-2xl" x-text="loading ? 'Sedang memuat komentar' : 'Belum ada komentar'">
        </p>
      </div>
    </div>
  </template>
  <ul>
    <template x-for="comment in comments" x-bind:key="comment.id">
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
            <span class="block text-xs">Time ago</span>
          </div>
          <div class='prose mb-3 max-w-none' x-html='comment.html_body'></div>
          <button type='button' x-show="($store.authStore.auth?.id === comment.user.id)">Delete</button>
          <button x-bind:class="{ 'text-red': liked }">Like<span x-text='comment.like_count'></span></button>
        </div>
      </li>
    </template>
  </ul>
</div>
