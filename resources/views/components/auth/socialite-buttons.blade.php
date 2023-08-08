@props(['type' => 'login'])

<p class="mb-3 text-center text-lg uppercase tracking-widest text-gray-700">
  {{ $type }} dengan
</p>
<div class="grid grid-cols-3 gap-3">
  <a class="flex justify-center border border-gray-300 py-3 hover:shadow"
    href="{{ route('login.socialite', 'google') }}" data-turbo="false"
    title="{{ $type }} dengan Google" rel="noreferrer">
    <x-svg.google width="24" height="24" />
  </a>
  <a class="flex justify-center border border-gray-300 py-3 hover:shadow"
    href="{{ route('login.socialite', 'facebook') }}" data-turbo="false"
    title="{{ $type }} dengan Facebook" rel="noreferrer">
    <x-svg.facebook width="24" height="24" />
  </a>
  <a class="flex justify-center border border-gray-300 py-3 hover:shadow"
    href="{{ route('login.socialite', 'github') }}" data-turbo="false"
    title="{{ $type }} dengan GitHub" rel="noreferrer">
    <x-svg.github width="24" height="24" />
  </a>
</div>

<div class="flex items-center py-3">
  <span class="block h-px flex-1 bg-gray-300"></span>
  <span class="block p-3 leading-none text-gray-500">atau</span>
  <span class="block h-px flex-1 bg-gray-300"></span>
</div>
