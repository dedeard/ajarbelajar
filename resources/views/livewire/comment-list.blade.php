<li class="flex px-3 py-5 odd:bg-gray-50">
  <div class="pr-3">
    <a href="{{ route('users.show', $comment->user->username) }}" class="block h-10 w-10 rounded-full border">
      <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->name }}" class="block w-full rounded-full" />
    </a>
  </div>

  <div class="flex-1">
    <div class="mb-3 flex h-10 flex-col justify-center">
      <a href="{{ route('users.show', $comment->user->username) }}" class="block text-sm font-semibold capitalize text-primary-600">
        {{ $comment->user->name }}
      </a>
      <span class="block text-xs">{{ $comment->created_at->diffFOrHumans() }}</span>
    </div>
    <div class="prose mb-3 max-w-none">
      {!! $comment->html_body !!}
    </div>
    <div class="flex justify-end">
      <button class="flex items-center justify-center leading-none">
        <span class="block text-red-600">
          <x-svg.heart width="20" height="20" fill="currentColor" />
        </span>
        <span class="ml-1 block">30</span>
      </button>
    </div>
  </div>
</li>
