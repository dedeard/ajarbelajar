<div class="avatar-toggle-wrapper relative ml-3 h-9 w-9">
  <button class="block h-9 w-9 rounded-full p-0">
    <img class="block h-full w-full rounded-full" src="{{ $user->avatar_url }}" />
  </button>
  <div class="profile-dropdown absolute right-0 top-full mt-3 w-60">
    <span class="absolute right-1 -top-1 h-6 w-6 rotate-45 transform rounded bg-primary-600"></span>
    <div class="relative z-10 rounded border border-gray-100 bg-white p-3 shadow-lg">
      <div class="flex p-3">
        <figure class="m-auto block h-24 w-24 rounded-full">
          <img class="block h-full w-full rounded-full" src="{{ $user->avatar_url }}" />
        </figure>
      </div>
      <h3 class="text-md capitalized w-full truncate text-center font-semibold">
        {{ $user->name }}
      </h3>
      <p class="w-full truncate text-center text-sm opacity-70">
        {{ '@' }}{{ $user->username }}
      </p>
      <div class="pt-3">
        <a href="{{ route('dashboard.activities') }}"
          class="toggle-color mb-3 flex h-9 w-full items-center justify-center rounded-full p-0 text-sm font-semibold">
          Dasbor Saya</a>
        <a href="{{ route('dashboard.edit-profile') }}"
          class="toggle-color mb-3 flex h-9 w-full items-center justify-center rounded-full p-0 text-sm font-semibold">
          Edit Profil</a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <x-button class="h-9 rounded-full !py-0" variant="red">Keluar</x-button>
        </form>
      </div>
    </div>
  </div>
</div>
