<div x-data="{
    name: '',
    uploading: false,
    progress: 0,
    get message() {
        return (this.progress < 100) ? `SEDANG DIUNGGAH: ${this.progress}%` : 'VIDEO SEDANG DIPROSES'
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
                formData.append('video', file);
                this.name = file ? file.name : ''
                const { data } = await window.axios.post('{{ route('dashboard.lessons.store.episode', ['lesson' => $lesson->id]) }}', formData, { onUploadProgress });
                Livewire.emit('episode-created')
                window.fire.success(data.message)
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
}">
  <div class="flex min-h-[150px] w-full p-3">
    <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50 p-3">
      <p class="m-auto text-center text-sm leading-none" x-text="name || 'KLIK DISINI ATAU SERET VIDIO KESINI UNTUK MEMBUAT EPISODE BARU'">
      </p>
      <p class="text-center text-sm" x-show="uploading" x-text="message"></p>
      <input type="file" accept="video/*" x-on:change="onChange" class="absolute top-0 left-0 z-10 block h-full w-full opacity-0" />
    </div>
  </div>
</div>
