<div x-data="{
    name: '',
    uploading: false,
    progress: 0,
    get message() {
        return (this.progress < 100) ? `SEDANG DIUNGGAH: ${this.progress}%` : 'GAMBAR SEDANG DIPROSES'
    },
    onchange(e) {
        const [file] = e.target.files
        this.name = file ? file.name : ''
    },
    onComplete() {
        this.name = ''
        this.uploading = false
        this.progress = 0
    }
}" x-on:livewire-upload-start="uploading = true" x-on:livewire-upload-progress="progress = $event.detail.progress"
  x-on:livewire-upload-error="onComplete" x-on:cover-error="onComplete" x-on:cover-created="onComplete">
  @if (session()->has('message'))
    <div class="border-l-4 border-primary-600 bg-primary-100 px-3 py-4 text-primary-600">
      {{ session('message') }}
    </div>
  @endif
  @error('image')
    <div class="border-l-4 border-red-600 bg-red-100 px-3 py-4 text-red-600">
      {{ $message }}
    </div>
  @enderror
  <div class="p-3">
    <div class="md:flex">
      <div id="dd" class="bg-cover bg-center md:w-80" x-bind:style="`background-image: url('{{ $lesson->cover_url['large'] }}')`">
        <img src="{{ $lesson->cover_url['large'] }}" class="invisible block w-full opacity-0" aria-hidden="true" />
      </div>
      <div class="flex min-h-[100px] flex-1 flex-col md:pl-3">
        <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50 p-3">
          <p class="m-auto text-center text-sm leading-none" x-text="name || 'KLIK DISINI ATAU SERET GAMBAR KESINI'"></p>
          <p class="text-center text-sm" x-show="uploading" x-text="message"></p>
          <input x-bind:disabled="uploading" type="file" aria-hidden="true" wire:model="image" accept="image/*" x-on:change="onchange"
            class="absolute z-10 block h-full w-full opacity-0" />
        </div>
      </div>
    </div>
  </div>
</div>
