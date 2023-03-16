@props(['episode'])

<form x-data="{
    async submit() {
        const bodyEl = document.getElementsByName('body')[0]
        if (bodyEl) {
            try {
                await window.axios.post('{{ route('comments.store', $episode->id) }}', { body: bodyEl.value })
                if (typeof window.EDJS?.clear === 'function') window.EDJS.clear()
                Livewire.emit('comment-created')
                window.fire.success('Berhasil membuat komentar')
            } catch (e) {
                window.fire.error(e.response?.data.message || e.message)
            }
        }
    }
}" x-on:submit.prevent="submit">
  <h4 class="border-b py-4 px-5 text-sm font-semibold uppercase">
    Tulis Komentar
  </h4>
  <div class="border-b">
    <x-editorjs name="body" min-height="80" placeholder="Tulis komentar mu disini." />
  </div>
  <div class="border-b p-3">
    <x-button>Komentar</x-button>
  </div>
  <div>
</form>
