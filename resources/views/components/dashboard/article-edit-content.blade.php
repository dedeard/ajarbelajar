@props(['article'])

<div class="mb-3 bg-white rounded shadow pt-3">
  <form action="{{ route('dashboard.articles.update.content', $article->id) }}" method="POST">
    @csrf
    @method('PUT')
    <x-editorjs name="content" :value="$article->content" />
    <div class="p-3">
      <x-button value="Simpan" />
    </div>
  </form>
</div>
