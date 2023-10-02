<x-app-layout dashboard title="Notifikasi" header="Notifikasi">
  <x-slot:actions>
    <a href="{{ route('notifications.markall') }}"
      class="block rounded-full bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-red-700">
      Tandai semua telah dibaca
    </a>
  </x-slot:actions>
  @if (!count($notifications))
    <x-blocks.blank>BELUM ADA NOTIFIKASI</x-blocks.blank>
  @else
    <div class="container p-3">
      <div class="grid grid-cols-1 gap-3">
        @foreach ($notifications as $notification)
          <a href="{{ route('notifications.read', $notification->id) }}"
            class="@if (!$notification->read_at) border-red-600 @endif block border-l-4 bg-white p-3 shadow-sm hover:bg-gray-50">
            <p class="text-xs">{{ $notification->created_at->diffForHumans() }}
            </p>
            <h3>{{ $notification->data['message'] }}</h3>
          </a>
        @endforeach
      </div>
      {{ $notifications->links() }}
    </div>
  @endif
</x-app-layout>

