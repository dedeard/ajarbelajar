@props(['episode'])

<form x-data="{
    async submit(e) {
        const bodyEl = document.getElementsByName('body')[0]
        if (bodyEl) {
            try {
                await window.axios.post('{{ route('comments.store', $episode->id) }}', { body: bodyEl.value })
                if (typeof window.EDJS?.clear === 'function') window.EDJS.clear()
                Livewire.emit('comment-created')
                window.fire.success('Berhasil membuat komentar')
                e.target.reset()
            } catch (e) {
                window.fire.error(e.response?.data.message || e.message)
            }
        }
    }
}" x-on:submit.prevent="submit">
  <h4 class="border-b px-5 py-4 text-sm font-semibold uppercase">
    Tulis Komentar
  </h4>
  <div class="border-b">
    <livewire:markdown-editor name="body" />
  </div>
  <div class="border-b p-3">
    <x-button>Komentar</x-button>
  </div>
  <div>
</form>
