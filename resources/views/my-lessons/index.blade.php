<x-app-layout dashboard title="Pelajaran Saya" header="Pelajaran Saya">
  <x-slot:actions>
    <a href="{{ route('my-lessons.create') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Buat Pelajaran
    </a>
  </x-slot:actions>
  <x-blocks.tab route="my-lessons.index" :tab="$tab" :lists="[
      'all' => ['params' => [], 'text' => 'Semua'],
      'public' => ['params' => ['tab' => 'public'], 'text' => 'Publik'],
      'draft' => ['params' => ['tab' => 'draft'], 'text' => 'Draf'],
  ]">

    @if (!count($lessons))
      <x-blocks.blank>BELUM ADA PELAJARAN</x-blocks.blank>
    @else
      <div class="container p-3">
        <div class="grid grid-cols-1 gap-3">
          @foreach ($lessons as $lesson)
            <a class="flex flex-col border bg-white hover:bg-gray-50 md:flex-row" href="{{ route('my-lessons.edit', $lesson->id) }}">
              <div class="relative p-3 md:w-52">
                @if ($lesson->public)
                  <span class="bg-primary absolute left-2 top-2 bg-primary-600 px-2 py-1 text-xs text-white shadow">PUBLIK</span>
                @endif
                <img class="block w-full" src="{{ $lesson->cover_urls['thumb'] }}" alt="Gambar dari pelajaran: {{ $lesson->title }}" />
              </div>
              <div class="flex-1 p-3 pt-0 md:pl-0 md:pt-3">
                <div class="mb-2">
                  <p class="fort-semibold text-xs">Diperbarui
                    {{ $lesson->updated_at->diffForHumans() }}</p>
                  @if ($lesson->category)
                    <span class="border bg-gray-100 px-2 py-1 text-2xs font-semibold">{{ $lesson->category->name }}</span>
                  @endif
                </div>
                <h3 class="font-semibold">{{ $lesson->title }}</h3>
                <p class="text-xs">Dibuat pada
                  {{ $lesson->created_at->translatedFormat('l, d F Y') }}</p>
              </div>
            </a>
          @endforeach
        </div>
        {{ $lessons->links() }}
      </div>
    @endif
  </x-blocks.tab>
</x-app-layout>
