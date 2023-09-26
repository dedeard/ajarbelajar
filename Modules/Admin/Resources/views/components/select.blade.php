<!-- resources/views/components/adminlte_select.blade.php -->
@props(['label', 'name', 'options', 'selected' => null, 'placeholder' => '', 'required' => false])

<div class="form-group mb-3">
  <label for="{{ $name }}">{{ $label }}</label>
  <select class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" id="{{ $name }}"
    @if ($required) required @endif>
    @if ($placeholder)
      <option value="" disabled selected>{{ $placeholder }}</option>
    @endif
    @foreach ($options as $value => $option)
      <option value="{{ $value }}" @if ($value == old($name, $selected)) selected @endif>{{ $option }}
      </option>
    @endforeach
  </select>
  @error($name)
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
  @enderror
</div>
