@props(['user'])

<a href="{{ route('users.show', $user->username) }}" class="group block border bg-white p-2 hover:bg-gray-50">
  <div class="relative flex items-center">
    <div class="flex flex-col items-center justify-center">
      <div class="w-14 rounded-full border bg-white p-1 group-hover:bg-gray-200">
        @if ($user->avatar_url)
          <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="block h-full w-full rounded-full" />
        @else
          <x-avatar :name="$user->name" class="block h-full w-full rounded-full" />
        @endif
      </div>
    </div>
    <div class="flex-1 truncate pl-2">
      <h3 class="mb-1 truncate text-sm font-semibold capitalize leading-none">
        {{ $user->name }}</h3>
      <p class="truncate text-xs capitalize leading-none text-gray-600">
        {{ '@' . $user->username }}</p>
    </div>
  </div>
</a>
