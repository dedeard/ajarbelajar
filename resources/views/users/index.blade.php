<x-app-layout title="Pengguna" header="Pengguna">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($users as $user)
        <x-cards.user-list :$user />
      @endforeach
    </div>
    {{ $users->links() }}
  </div>
</x-app-layout>
