<x-app-layout dashboard :title="$episode->index + 1 . '. ' . $episode->title" :header="'Edit Episode ' . $episode->index + 1">
  <x-slot:head>
    @vite(['resources/js/videoplayer.js'])
  </x-slot:head>

  <x-slot:actions>
    <a href="{{ route('dashboard.lessons.edit', ['lesson' => $lesson->id, 'tab' => 'episodes']) }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Kembali
    </a>
  </x-slot:actions>

  <div class="container p-3">
    <div class="md:flex md:flex-row-reverse">
      <div class="md:w-[320px]">
        <x-video-player src="{{ $episode->video_url }}" :autoplay="false" />
      </div>
      <div class="md:flex-1 md:pr-3">
        <form
          action="{{ route('dashboard.lessons.episode.update', ['lesson' => $lesson->id, 'episode' => $episode->id]) }}"
          method="POST" class="mb-3 border bg-white">
          @csrf
          @method('PUT')
          <div class="border-b p-3">
            <h3 class="font-bold uppercase">Edit Detail</h3>
          </div>
          <div class="border-b p-3">
            <x-input-wrap label="Judul">
              <x-input name="title" placeholder="Judul"
                value="{{ $episode->title }}" />
            </x-input-wrap>
            <x-input-wrap label="Deskripsi" useDiv>
              <livewire:markdown-editor name="description" :value="$episode->description"
                :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
            </x-input-wrap>
          </div>
          <div class="p-3">
            <x-button value="Simpan" />
          </div>
        </form>
      </div>
    </div>
  </div>

</x-app-layout>
