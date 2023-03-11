@props(['post', 'type' => 'lesson'])

<a class="mb-3 flex flex-col rounded bg-white shadow hover:shadow-lg md:flex-row"
  href="{{ route('dashboard.' . $type . 's.edit', $post->id) }}">
  <div class="relative p-3 md:w-52">
    @if ($post->public)
      <span class="bg-primary absolute top-2 left-2 rounded bg-primary-600 px-2 py-1 text-xs text-white shadow">PUBLIK</span>
    @endif
    <img class="block w-full rounded" src="{{ $post->cover_url['thumb'] }}" alt="Gambar dari pelajaran: {{ $post->title }}" />
  </div>
  <div class="flex-1 p-3 pt-0 md:pl-0 md:pt-3">
    <div class="mb-2">
      <p class="fort-semibold text-xs">Diperbarui {{ $post->updated_at->diffForHumans() }}</p>
      @if ($post->category)
        <span class="rounded-sm border bg-gray-100 px-2 py-1 text-2xs font-semibold">{{ $post->category->name }}</span>
      @endif
    </div>
    <h3 class="font-semibold">{{ $post->title }}</h3>
    <p class="text-xs">Dibuat pada {{ $post->created_at->translatedFormat('l, d F Y') }}</p>
  </div>
</a>
