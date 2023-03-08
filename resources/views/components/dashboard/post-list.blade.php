@props(['post', 'type' => 'lesson'])

<a class="mb-3 rounded flex flex-col md:flex-row bg-white shadow hover:shadow-lg" href="{{ route('dashboard.' . $type . 's.edit', $post->id) }}">
  <div class="p-3 relative md:w-52">
    @if ($post->public)
      <span class="bg-primary absolute top-2 left-2 text-xs  text-white shadow px-2 py-1 rounded bg-primary-600">PUBLIK</span>
    @endif
    <img class="block w-full rounded" src="{{ $post->cover_url['thumb'] }}" alt="Gambar dari pelajaran: {{ $post->title }}" />
  </div>
  <div class="p-3 pt-0 md:pl-0 md:pt-3 flex-1">
    <div class="mb-2">
      <p class="fort-semibold text-xs">Diperbarui {{ $post->updated_at->diffForHumans() }}</p>
      @if ($post->category)
        <span class="text-2xs font-semibold bg-gray-100 border px-2 py-1 rounded-sm">{{ $post->category->name }}</span>
      @endif
    </div>
    <h3 class="font-semibold">{{ $post->title }}</h3>
    <p class="text-xs">Dibuat pada {{ $post->created_at->translatedFormat('l, d F Y') }}</p>
  </div>
</a>
