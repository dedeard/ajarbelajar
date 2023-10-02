@props(['lesson'])

<turbo-frame id="my-lessons.edit-details">
  <x-alert />
  <div class="mb-3 border bg-white">
    <form action="{{ route('my-lessons.update', $lesson->id) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="border-b p-3">
        <x-input.text name="title" label="Judul" placeholder="Judul" value="{{ $lesson->title }}" />
        <x-input.select name="category" label="Kategori">
          <option value="" disabled>Pilih Kategori</option>
          @foreach (App\Models\Category::all() as $category)
            <option value="{{ $category->id }}" @if ($category->id === $lesson->category_id) selected @endif>
              {{ $category->name }}</option>
          @endforeach
        </x-input.select>
        <x-input.markdown name="description" label="Deskripsi" :value="$lesson->description" :disabled-tools="['heading', 'blockquote', 'table', 'horizontalRule']" />
        <x-input.checkbox name="public" label="Publikasikan pelajaran" :checked="$lesson->public" />
      </div>
      <div class="p-3">
        <x-input.button value="Simpan" />
      </div>
    </form>
  </div>
</turbo-frame>
