<x-app-layout dashboard :title="$episode->index + 1 . '. ' . $episode->title" :header="'Edit Episode ' . $episode->index + 1">
  <x-slot:head>
    @vite(['resources/js/plyr.js'])
  </x-slot:head>

  <x-slot:actions>
    <div class="flex" x-data>
      <form class="hidden" x-ref="formDelete"
        action="{{ route('my-lessons.episode.destroy', ['my_lesson' => $lesson->id, 'episode' => $episode->id]) }}" method="POST">
        @csrf
        @method('DELETE')
      </form>
      <button x-on:click="$store.deleteConfirm(() => $refs.formDelete.submit())"
        class="mr-2 block rounded-full bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-red-700">
        Hapus
      </button>
      <a href="{{ route('my-lessons.edit', ['my_lesson' => $lesson->id, 'tab' => 'episodes']) }}"
        class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
        Kembali
      </a>
    </div>
  </x-slot:actions>

  <x-tab route="my-lessons.episode.edit" :tab="$tab" class="grid-cols-2" :lists="[
      'details' => [
          'params' => ['episode' => $episode->id, 'my_lesson' => $lesson->id],
          'text' => 'Edit Detail',
      ],
      'subtitles' => [
          'params' => [
              'episode' => $episode->id,
              'my_lesson' => $lesson->id,
              'tab' => 'subtitles',
          ],
          'text' => 'Edit Subtitle',
      ],
  ]">
    <div class="container p-3">
      <turbo-frame id="my-lessons.edit-episode">
        <x-alert />
        <div class="md:flex md:flex-row-reverse">
          <div class="md:w-[320px]">
            <x-video-player :$episode />
          </div>
          <div class="md:flex-1 md:pr-3">
            @if ($tab === 'details')
              <form action="{{ route('my-lessons.episode.update', ['my_lesson' => $lesson->id, 'episode' => $episode->id]) }}"
                method="POST" class="mb-3 border bg-white">
                @csrf
                @method('PUT')
                <div class="border-b p-3">
                  <h3 class="font-bold uppercase">Edit Detail</h3>
                </div>
                <div class="border-b p-3">
                  <x-inputs.wrapper label="Judul">
                    <x-inputs.text name="title" placeholder="Judul" value="{{ $episode->title }}" />
                  </x-inputs.wrapper>
                  <x-inputs.wrapper label="Deskripsi" useDiv>
                    <x-inputs.markdown name="description" :value="$episode->description" :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
                  </x-inputs.wrapper>
                </div>
                <div class="p-3">
                  <x-inputs.button value="Simpan" />
                </div>
              </form>
            @else
              <x-my-lessons.subtitle-management :episode="$episode" />
            @endif
          </div>
        </div>
      </turbo-frame>
    </div>
  </x-tab>

</x-app-layout>

