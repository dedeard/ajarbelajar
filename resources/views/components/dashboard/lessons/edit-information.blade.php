<form method="POST" action="{{ route('dashboard.lessons.update', ['lesson' => $lesson->id]) }}">
  @csrf
  @method('PUT')
  <div class="border-b p-3">
    <x-input-wrap label="Judul">
      <x-input name="title" placeholder="Judul" value="{{ $lesson->title }}" />
    </x-input-wrap>
    <x-input-wrap label="Kategori">
      <x-input name="category" type="select">
        <option value="" disabled>Pilih Kategori</option>
        @foreach (App\Models\Category::all() as $category)
          <option value="{{ $category->id }}" @if ($category->id === $lesson->category_id) selected @endif>{{ $category->name }}</option>
        @endforeach
      </x-input>
    </x-input-wrap>
    <x-input-wrap label="Deskripsi">
      <x-input name="description" placeholder="Deskripsi" type="textarea" rows="8" value="{{ $lesson->description }}" />
    </x-input-wrap>
    <div class="flex items-center py-3">
      <input name="public" id="checked-checkbox" type="checkbox" @if ($lesson->public) checked @endif
        class="text-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 h-4 w-4 rounded border-gray-300 bg-gray-100 shadow focus:ring-2">
      <label for="checked-checkbox" class="ml-2 text-sm font-medium text-gray-900">Publikasikan pelajaran</label>
    </div>
  </div>
  <div class="p-3">
    <x-button value="Simpan" />
  </div>
</form>