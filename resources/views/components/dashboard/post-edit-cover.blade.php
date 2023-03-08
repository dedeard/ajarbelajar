@props(['post', 'type' => 'lesson'])

<div x-data="{
    name: '',
    uploading: false,
    url: '{{ $post->cover_url['large'] }}',
    progress: 0,
    get message() {
        return (this.progress < 100) ? `Sedang Diunggah: ${this.progress}%` : 'Gambar sedang diproses'
    },
    async onChange(e) {
        this.uploading = true
        const onUploadProgress = (e) => {
            this.progress = Math.round((e.loaded * 100) / e.total);
        }
        try {
            const [file] = e.target.files
            if (file) {
                const formData = new FormData();
                formData.append('image', file);
                this.name = file ? file.name : ''
                const { data } = await window.axios.post('{{ route('dashboard.' . $type . 's.update.cover', [$type => $post->id]) }}', formData, { onUploadProgress });
                this.url = data.large
                window.fire.success('Gambar berhasil diubah.')
            }
        } catch (err) {
            window.fire.error(e.response?.data.message || e.message)
        }
        this.uploading = false
    },
    onComplete() {
        this.name = ''
        this.uploading = false
        this.progress = 0
    }
}" class="p-3 mb-3 bg-white rounded shadow">
  <img x-bind:src="url" class="block w-full" />
  <div class="flex">
    <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50/10 p-3">
      <p class="m-auto text-center text-sm leading-none" x-text="uploading ? message : 'Klik disini untuk mengedit gambar'"></p>
      <input x-bind:disabled="uploading" type="file" aria-hidden="true" accept="image/*" x-on:change="onChange"
        class="absolute z-10 block h-full w-full opacity-0" />
    </div>
  </div>
</div>
