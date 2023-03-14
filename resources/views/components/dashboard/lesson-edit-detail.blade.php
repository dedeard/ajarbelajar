@props(['lesson'])

<div class="mb-3 border bg-white">
  <form action="{{ route('dashboard.lessons.update', $lesson->id) }}" method="POST">
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
      <div class="flex items-center py-3">
        <input name="public" id="public-checkbox" type="checkbox" @if ($lesson->public) checked @endif
          class="border-gray-300 bg-gray-100 !ring-0 hover:border-primary-600">
        <label for="public-checkbox" class="ml-2 text-sm font-medium text-gray-900">Publikasikan pelajaran</label>
      </div>
    </div>
    <div class="p-3">
      <x-button value="Simpan" />
    </div>
  </form>
</div>
