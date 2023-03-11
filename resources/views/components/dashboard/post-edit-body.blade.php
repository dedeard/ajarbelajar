@props(['post', 'type' => 'lesson', 'name' => 'description', 'label' => 'Deskripsi pelajaran'])

<div class="mb-3 rounded bg-white px-3 pt-3 shadow">
  <form action="{{ route('dashboard.' . $type . 's.update.' . $name, $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <span class="block text-sm">{{ $label }}</span>
    <x-editorjs :name="$name" :value="$post[$name]" />
    <div class="py-3">
      <x-button value="Simpan" />
    </div>
  </form>
</div>
