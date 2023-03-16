@props(['name' => Str::random(6), 'value' => '', 'minHeight' => 150, 'placeholder' => ''])

@php
  $error = $errors->first($name);
  $value = $value ? $value : old($name);
@endphp

<textarea name="{{ $name }}" id="{{ $name }}-value" class="hidden">{{ $value }}</textarea>
<div class="@if ($error) border-red-600 @endif border bg-white p-3 md:px-5">
  <div id="{{ $name }}-holder"></div>
</div>
<script>
  (() => {
    const holderEl = document.getElementById('{{ $name }}-holder')
    const valueEl = document.getElementById('{{ $name }}-value')
    const initEditorJS = () => {
      if (typeof window.EDJS?.destroy === 'function') {
        window.EDJS.destroy()
      }
      window.EDJS = window.initEditor({
        holder: holderEl,
        value: valueEl.value,
        onChange: (value) => {
          valueEl.value = value
        },
        minHeight: {{ $minHeight }},
        placeholder: '{{ $placeholder }}'
      })
    }
    if (window.initEditor) {
      initEditorJS()
    } else {
      window.addEventListener('load', initEditorJS)
    }
  })()
</script>
@if ($error)
  <span class="block text-xs text-red-900">{{ $error }}</span>
@endif
