@props(['lesson', 'name' => 'description', 'label' => 'Deskripsi pelajaran'])

<div action="{{ route('dashboard.lessons.update.description', $lesson->id) }}" method="POST" class="mb-3 border bg-white">
  @csrf
  @method('PUT')
  <div class="border-b p-3">
    <span class="block text-sm">Deskripsi pelajaran</span>
    <x-editorjs name="description" :value="$lesson->description" />
  </div>
  <div class="p-3">
    <x-button value="Simpan" />
  </div>
</div>
