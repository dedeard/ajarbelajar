<x-app-layout dashboard title="Buat Pelajaran" header="Buat Pelajaran Baru">
  <x-slot:actions>
    <a href="{{ route('my-lessons.index') }}"
      class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
      Batal
    </a>
  </x-slot:actions>

  <div class="container p-3">
    <form method="POST" action="{{ route('my-lessons.store') }}" class="border bg-white">
      @csrf
      <div class="p-3">
        <x-inputs.wrapper label="Judul">
          <x-inputs.text name="title" placeholder="Judul" />
        </x-inputs.wrapper>
        <x-inputs.wrapper label="Kategori">
          <x-inputs.select name="category">
            <option value="" @if (!old('category')) selected @endif disabled>Pilih
              Kategori
            </option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}" @if (old('category') == $category->id) selected @endif>
                {{ $category->name }}</option>
            @endforeach
          </x-inputs.select>
        </x-inputs.wrapper>
        <x-inputs.wrapper label="Deskripsi" useDiv>
          <x-inputs.markdown name="description" :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
        </x-inputs.wrapper>
      </div>

      <div class="block border-t p-3">
        <x-inputs.button value="Buat Pelajaran" />
      </div>
    </form>
  </div>

</x-app-layout>
