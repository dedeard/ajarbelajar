@props(['label', 'name', 'value' => null, 'required' => false, 'rows' => 3])

<div class="form-group mb-3">
  <label for="{{ $name }}">{{ $label }}</label>
  <textarea class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
    placeholder="{{ $label }}" @if ($required) required @endif>{{ old($name, $value) }}</textarea>
  @error($name)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
