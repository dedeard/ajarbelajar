@props(['lesson'])

<a class="mb-3 rounded flex flex-col md:flex-row bg-white shadow hover:shadow-lg" href="{{ route('dashboard.lessons.edit', $lesson->id) }}">
  <div class="p-3 relative md:w-52">
    @if ($lesson->public)
      <span class="bg-primary absolute top-2 left-2 text-xs  text-white shadow px-2 py-1 rounded bg-primary-600">PUBLIK</span>
    @endif
    <img class="block w-full rounded" src="{{ $lesson->cover_url['thumb'] }}" alt="Gambar dari pelajaran: {{ $lesson->title }}" />
  </div>
  <div class="p-3 pt-0 md:pl-0 md:pt-3 flex-1">
    <div class="mb-2">
      <p class="fort-semibold text-xs">Diperbarui {{ $lesson->updated_at->diffForHumans() }}</p>
      @if ($lesson->category)
        <span class="text-2xs font-semibold bg-gray-100 border px-2 py-1 rounded-sm">{{ $lesson->category->name }}</span>
      @endif
    </div>
    <h3 class="font-semibold">{{ $lesson->title }}</h3>
    <p class="text-xs">Dibuat pada {{ $lesson->created_at->translatedFormat('l, d F Y') }}</p>
  </div>
</a>
