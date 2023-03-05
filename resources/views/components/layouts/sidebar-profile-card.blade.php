<div class="mb-3 flex w-full flex-col rounded bg-gray-100">
  <div class="flex w-full items-center p-3">
    <div class="pr-2">
      <figure class="m-auto block h-12 w-12 rounded-full border border-gray-200 bg-white p-1">
        <img class="block h-full w-full rounded-full" src="{{ Auth::user()->avatar_url }}" />
      </figure>
    </div>
    <div class="flex-1 overflow-hidden">
      <h3 class="mb-1 truncate font-semibold capitalize leading-none">{{ Auth::user()->name }}</h3>
      <p class="truncate text-sm leading-none opacity-70">{{ '@' . Auth::user()->username }}</p>
    </div>
  </div>
</div>
