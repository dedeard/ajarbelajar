@props([
    'type' => 'text',
    'label',
    'name',
    'value' => null,
    'required' => false,
])

<div class="form-group mb-3">
  <label for="{{ $name }}">{{ $label }}</label>
  <input type="{{ $type }}"
    class="form-control @error($name) is-invalid @enderror"
    name="{{ $name }}" id="{{ $name }}"
    value="{{ old($name, $value) }}" placeholder="{{ $label }}"
    @if ($required) required @endif>
  @error($name)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
