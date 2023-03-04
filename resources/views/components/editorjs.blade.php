@props(['value', 'name' => ''])
<script>
  window.onload = function() {
    const editor = window.initEditor('editorjs', 'editorjs-vallue')
  }
</script>
<textarea name="{{ $name }}}" id="editorjs-vallue" class="hidden">{{ $value }}</textarea>
<div class="rounded border bg-white p-3">
  <div id="editorjs" placeholder='Let`s write an awesome story!'></div>
</div>
