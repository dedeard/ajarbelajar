@props(['name', 'value' => ''])

@php
  $error = $errors->first($name);
  $value = $value ? $value : old($name);
@endphp

<x-slot:script>
  <script>
    (() => {
      const holderEl = document.getElementById('{{ $name }}-holder')
      const valueEl = document.getElementById('{{ $name }}-value')
      const initEditorJS = () => {
        window.initEditor({
          holder: holderEl,
          value: valueEl.value,
          onChange: (value) => {
            valueEl.value = value
          }
        })
      }
      if (window.initEditor) {
        initEditorJS()
      } else {
        window.onload = initEditorJS
      }
    })()
  </script>
</x-slot:script>

<textarea name="{{ $name }}" id="{{ $name }}-value" class="hidden">{{ $value }}</textarea>
<div class="rounded border bg-white p-3">
  <div id="{{ $name }}-holder" placeholder='Let`s write an awesome story!'></div>
</div>
@if ($error)
  <span class="block text-xs text-red-900">{{ $error }}</span>
@endif
