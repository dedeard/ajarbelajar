<x-app-layout title="Daftar pelajaran" header="Pelajaran">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($lessons as $lesson)
        <x-lesson-list :lesson="$lesson" :user="Auth::user()" />
      @endforeach
    </div>
  </div>
</x-app-layout>
