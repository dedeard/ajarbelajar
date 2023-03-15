<x-app-layout title="Pengguna" header="Pengguna">
  <div class="container p-3">
    <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($users as $user)
        <a href="{{ route('users.show', $user->username) }}" class="group block border bg-white p-2 hover:bg-gray-50">
          <div class="relative flex items-center">
            <div class="flex flex-col items-center justify-center">
              <div class="w-14 rounded-full border bg-white p-1 group-hover:bg-gray-200">
                <img class="w-full rounded-full" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" />
              </div>
            </div>
            <div class="flex-1 truncate pl-2">
              <h3 class="mb-1 truncate text-sm font-semibold capitalize leading-none">{{ $user->name }}</h3>
              <p class="truncate text-xs capitalize leading-none text-gray-600">{{ '@' . $user->username }}</p>
            </div>
          </div>
        </a>
      @endforeach
    </div>
    {{ $users->links() }}
  </div>
</x-app-layout>
