<x-app-layout dashboard header="Favorit">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($favorites as $favorite)
        <x-lesson-list :lesson="$favorite->lesson" :user="Auth::user()" />
      @endforeach
    </div>
    {{ $favorites->links() }}
  </div>
</x-app-layout>
