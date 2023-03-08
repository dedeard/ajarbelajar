<x-dashboard-layout title="Buat Artikel">
  <div class="container p-3">

    <form method="POST" action="{{ route('dashboard.articles.store') }}" class="mb-3 rounded border-b-4 border-primary-500 bg-white shadow">
      @csrf
      <div class="flex items-center border-b px-3 py-5">
        <h3 class="flex-1 text-xl font-semibold">Buat Artikel Baru</h3>
        <div>
          <a href="{{ route('dashboard.articles.index') }}"
            class="block rounded-full bg-primary-600 px-4 py-2 text-sm text-white hover:bg-primary-700">
            Batal
          </a>
        </div>
      </div>

      <div class="p-3">
        <x-input-wrap label="Judul">
          <x-input name="title" placeholder="Judul" />
        </x-input-wrap>
        <x-input-wrap label="Kategori">
          <x-input name="category" type="select">
            <option value="" @if (!old('category')) selected @endif disabled>Pilih Kategori</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @if (old('category') == $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
          </x-input>
        </x-input-wrap>
      </div>

      <div class="block border-t p-3">
        <x-button value="Buat Artikel" />
      </div>
    </form>
  </div>

</x-dashboard-layout>
