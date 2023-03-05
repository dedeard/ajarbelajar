<form wire:submit.prevent="submit">
  @if (session()->has('message'))
    <div class="border-l-4 border-primary-600 bg-primary-100 px-3 py-4 text-primary-600">
      {{ session('message') }}
    </div>
  @endif
  <div class="border-b p-3">
    <x-input-wrap label="Judul">
      <x-input model="title" placeholder="Judul" />
    </x-input-wrap>
    <x-input-wrap label="Kategori">
      <x-input model="category" type="select">
        <option value="" disabled>Pilih Kategori</option>
        @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
      </x-input>
    </x-input-wrap>
    <x-input-wrap label="Deskripsi">
      <x-input model="description" placeholder="Deskripsi" type="textarea" rows="8" />
    </x-input-wrap>
    <div class="flex items-center py-3">
      <input wire:model="public" id="checked-checkbox" type="checkbox"
        class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 h-4 w-4 rounded border-gray-300 bg-gray-100 shadow focus:ring-2">
      <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900">Publikasikan pelajaran</label>
    </div>
  </div>
  <div class="p-3">
    <x-button value="Simpan" />
  </div>
</form>
