@props(['label', 'name', 'checked' => false])

<div class="form-check">
  <input class="form-check-input @error($name) is-invalid @enderror"
    type="checkbox" name="{{ $name }}" id="{{ $name }}"
    @if ($checked) checked @endif>
  <label class="form-check-label" for="{{ $name }}">
    {{ $label }}
  </label>
  @error($name)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
