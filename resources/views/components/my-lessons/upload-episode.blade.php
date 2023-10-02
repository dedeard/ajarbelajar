@props(['lesson'])

<div x-data="{
    name: '',
    fileInput: null,
    uploading: false,
    progress: 0,
    get message() {
        return (this.progress < 100) ? `Sedang Diunggah: ${this.progress}%` : 'Video sedang diproses'
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
                const { data } = await window.axios.post('{{ route('my-lessons.store.episode', $lesson->id) }}', formData, { onUploadProgress });
                Livewire.emit('episode-created')
                window.toast.success(data.message)
            }
        } catch (err) {
            window.toast.error(err.response?.data.message || err.message)
        }
        this.fileInput = null;
        this.uploading = false
    },
    onComplete() {
        this.name = ''
        this.uploading = false
        this.progress = 0
    }
}" class="border bg-white">
  <div class="flex min-h-[100px] w-full p-3">
    <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50 p-3">
      <p class="m-auto text-center text-sm leading-none" x-text="name || 'Klik disini untuk mengupload episode'">
      </p>
      <p class="text-center text-sm" x-show="uploading" x-text="message"></p>
      <input type="file" accept="video/*" x-model="fileInput" x-on:change="onChange"
        class="absolute left-0 top-0 z-10 block h-full w-full opacity-0" />
    </div>
  </div>
</div>
