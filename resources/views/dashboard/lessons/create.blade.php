<x-app-layout dashboard title="Buat Pelajaran" header="Buat Pelajaran Baru">
  <x-slot:actions>
    <a href="{{ route('dashboard.lessons.index') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Batal
    </a>
  </x-slot:actions>

  <div class="container p-3">
    <form method="POST" action="{{ route('dashboard.lessons.store') }}" class="border bg-white">
      @csrf
      <div class="p-3">
        <x-input-wrap label="Judul">
          <x-input name="title" placeholder="Judul" />
        </x-input-wrap>
        <x-input-wrap label="Kategori">
          <x-input name="category" type="select">
            <option value="" @if (!old('category')) selected @endif disabled>Pilih
              Kategori
            </option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @if (old('category') == $category->id) selected @endif>
                {{ $category->name }}</option>
            @endforeach
          </x-input>
        </x-input-wrap>
        <x-input-wrap label="Deskripsi" useDiv>
          <livewire:markdown-editor name="description" :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
        </x-input-wrap>
      </div>

      <div class="block border-t p-3">
        <x-button value="Buat Pelajaran" />
      </div>
    </form>
  </div>

</x-app-layout>
