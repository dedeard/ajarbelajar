<x-app-layout title="Riwayat" header="Riwayat">
  @if (!count($histories))
    <x-blocks.blank>BELUM ADA RIWAYAT</x-blocks.blank>
  @else
    <div class="container p-3">
      <div class="grid-col-1 grid gap-3">
        @foreach ($histories as $history)
          <a href="{{ route('lessons.watch', ['lesson' => $history->episode->lesson->slug, 'index' => $history->episode->index]) }}"
            class="flex border bg-white p-3 hover:bg-gray-50">
            <div class="w-16 md:w-24">
              <img class="block w-full" src="{{ $history->episode->lesson->cover_urls['small'] }}"
                alt="{{ $history->episode->lesson->title }}" />
            </div>
            <div class="my-auto flex-1 pl-3">
              <p class="text-xs">{{ $history->updated_at->diffForHumans() }}</p>
              <h3>{{ sprintf('%02d', $history->episode->index + 1) }}.
                {{ $history->episode->title }}</h3>
              <p class="text-xs">{{ $history->episode->lesson->title }}</p>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</x-app-layout>

