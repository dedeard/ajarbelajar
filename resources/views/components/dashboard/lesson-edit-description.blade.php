@props(['lesson', 'name' => 'description', 'label' => 'Deskripsi pelajaran'])

<form action="{{ route('dashboard.lessons.update.description', $lesson->id) }}"
  method="POST" class="mb-3 border-y bg-white">
  @csrf
  @method('PUT')
  <div>
    <span class="block border-x p-3 pb-1 text-sm">Deskripsi pelajaran</span>
    <livewire:markdown-editor name="description" :value="$lesson->description" />
  </div>
  <div class="border-x p-3">
    <x-button value="Simpan" />
  </div>
</form>
