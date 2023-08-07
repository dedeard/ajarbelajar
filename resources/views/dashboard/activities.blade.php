<x-app-layout dashboard title="Aktifitas saya" header="Aktifitas saya">
  @if (!count($activities))
    <x-dashboard.blank>BELUM ADA AKTIFITAS</x-dashboard.blank>
  @else
    <div class="container p-3">
      <div class="grid-col-1 grid gap-3">
        @foreach ($activities as $activity)
          <a href="{{ route('lessons.watch', ['lesson' => $activity->episode->lesson->slug, 'index' => $activity->episode->index]) }}"
            class="flex border bg-white p-3 hover:bg-gray-50">
            <div class="w-16 md:w-24">
              <img class="block w-full"
                src="{{ $activity->episode->lesson->cover_urls['small'] }}"
                alt="{{ $activity->episode->lesson->title }}" />
            </div>
            <div class="my-auto flex-1 pl-3">
              <p class="text-xs">{{ $activity->updated_at->diffForHumans() }}</p>
              <h3>{{ sprintf('%02d', $activity->episode->index + 1) }}.
                {{ $activity->episode->title }}</h3>
              <p class="text-xs">{{ $activity->episode->lesson->title }}</p>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</x-app-layout>
