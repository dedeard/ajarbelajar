@props(['post', 'type' => 'lesson', 'name' => 'description', 'label' => 'Deskripsi pelajaran'])

<div class="mb-3 bg-white rounded shadow pt-3 px-3">
  <form action="{{ route('dashboard.' . $type . 's.update.' . $name, $post->id) }}" method="POST">
    @csrf
    @method('PUT')
    <span class="block text-sm">{{ $label }}</span>
    <x-editorjs :name="$name" :value="$post->content" />
    <div class="py-3">
      <x-button value="Simpan" />
    </div>
  </form>
</div>
