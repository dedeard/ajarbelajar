<form x-data="{
    name: '',
    uploading: false,
    progress: 0,
    get message() {
        return (this.progress < 100) ? `SEDANG DIUNGGAH: ${this.progress}%` : 'SEDANG DIPROSES'
    },
    onChange(e) {
        const [file] = e.target.files
        this.name = file ? file.name : ''
    },
    onComplete() {
        this.name = ''
        this.uploading = false
        this.progress = 0
    }
}" wire:submit.prevent x-on:livewire-upload-start="uploading = true"
  x-on:livewire-upload-progress="progress = $event.detail.progress" x-on:livewire-upload-error="onComplete" x-on:episode-error="onComplete"
  x-on:episode-created="onComplete">
  @if (session()->has('message'))
    <div class="border-l-4 border-primary-600 bg-primary-100 px-3 py-4 text-primary-600">
      {{ session('message') }}
    </div>
  @endif
  @error('video')
    <div class="border-l-4 border-red-600 bg-red-100 px-3 py-4 text-red-600">
      {{ $message }}
    </div>
  @enderror
  <div class="flex min-h-[150px] w-full p-3">
    <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50 p-3">
      <p class="m-auto text-center text-sm leading-none" x-text="name || 'KLIK DISINI ATAU SERET VIDIO KESINI UNTUK MEMBUAT EPISODE BARU'">
      </p>
      <p class="text-center text-sm" x-show="uploading" x-text="message"></p>
      <input type="file" accept="video/*" wire:model="video" x-on:change="onChange"
        class="absolute top-0 left-0 z-10 block h-full w-full opacity-0" />
    </div>
  </div>
</form>
