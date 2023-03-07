<x-dashboard-layout title="Edit Pelajaran">
  <div class="container p-3">

    <div class="mb-3 rounded border-b-4 border-primary-500 bg-white shadow">
      <div class="flex items-center border-b px-3 py-5">
        <h3 class="flex-1 text-xl font-semibold">Edit Pelajaran</h3>
        <form x-data="{
            loading: false,
            onclick(e) {
                e.preventDefault()
                this.loading = true
                this.$store.deleteConfirm(() => {
                    this.$refs.formDeleteLesson.requestSubmit()
                }, () => {
                    this.loading = false
                }, {
                    text: 'Kamu akan menghapus pelajaran ini secara permanen!',
                })
            }
        }" x-ref="formDeleteLesson" method="POST" action="{{ route('dashboard.lessons.destroy', $lesson->id) }}">
          @csrf
          @method('DELETE')
          <x-button type="button" @click="onclick" x-bind:disabled="loading" variant="red"
            class="!block w-full h-full !bg-red-100 !text-red-900 hover:!bg-red-600 disabled:!bg-red-600 hover:!text-white !border-0 disabled:!text-transparent">
            Hapus</x-button>
        </form>
      </div>
      <div class="flex flex-col md:flex-row border-b">
        <div class="p-3 relative md:w-52">
          @if ($lesson->public)
            <span class="bg-primary absolute top-2 left-2 text-xs  text-white shadow px-2 py-1 rounded bg-primary-600">PUBLIK</span>
          @endif
          <img class="block w-full rounded" src="{{ $lesson->cover_url['thumb'] }}" alt="Gambar dari pelajaran: {{ $lesson->title }}" />
        </div>
        <div class="p-3 pt-0 md:pl-0 md:pt-3 flex-1">
          <div class="mb-2">
            <p class="fort-semibold text-xs">Diperbarui {{ $lesson->updated_at->diffForHumans() }}</p>
            @if ($lesson->category)
              <span class="text-2xs font-semibold bg-gray-100 border px-2 py-1 rounded-sm">{{ $lesson->category->name }}</span>
            @endif
          </div>
          <h3 class="font-semibold">{{ $lesson->title }}</h3>
          <p class="text-xs">Dibuat pada {{ $lesson->created_at->translatedFormat('l, d F Y') }}</p>
        </div>
      </div>
      <div class="grid grid-cols-3 border-b p-3 md:gap-3">
        <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id]) }}"
          class="@if ($tab === 'info') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Informasi</a>
        <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id, 'tab' => 'cover']) }}"
          class="@if ($tab === 'cover') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Gambar</a>
        <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id, 'tab' => 'episodes']) }}"
          class="@if ($tab === 'episodes') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Episode</a>
      </div>
      @if ($tab === 'info')
        <x-dashboard.lessons.edit-information :lesson="$lesson" />
      @elseif($tab === 'cover')
        <x-dashboard.lessons.edit-cover :lesson="$lesson" />
      @elseif($tab === 'episodes')
        <x-dashboard.lessons.upload-episode :lesson="$lesson" />
        <livewire:dashboard.lessons.show-episodes :lesson="$lesson" />
      @endif
    </div>
  </div>
</x-dashboard-layout>
