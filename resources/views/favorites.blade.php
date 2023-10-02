<x-app-layout title="Favorit saya" header="Favorit saya">
  @if (!count($favorites))
    <x-blocks.blank>BELUM ADA PELAJARAN FAVORIT</x-blocks.blank>
  @else
    <div class="container p-3">
      <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($favorites as $favorite)
          <x-cards.lesson-list :lesson="$favorite->lesson" />
        @endforeach
      </div>
      {{ $favorites->links() }}
    </div>
  @endif
</x-app-layout>
