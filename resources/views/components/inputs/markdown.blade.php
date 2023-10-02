@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'help' => '',
    'type' => 'minimal',
    'placeholder' => '',
    'error' => $errors->first($name),
])

<x-inputs.wrapper label="{{ $label }}" for="{{ $name }}">
  <div x-data="markdown" class="bg-white">
    <div class="flex border border-b-0">
      <button type="button"
        class="block items-center justify-center border-b-2 bg-white px-4 pb-2 pt-3 text-xs font-bold uppercase tracking-widest text-gray-500"
        :class="!preview ? '!border-primary-600 !text-gray-700' : ''" x-on:click="preview = false">Markdown</button>
      <button type="button"
        class="block items-center justify-center border-b-2 bg-white px-4 pb-2 pt-3 text-xs font-bold uppercase tracking-widest text-gray-500"
        :class="preview ? '!border-primary-600 !text-gray-700' : ''" x-on:click="preview = true">Preview</button>
      <span class="block flex-1 border-b-2"></span>
    </div>

    <textarea x-ref="textarea" rows="5"
      x-on:input="(e) => {
        e.target.style.height = 'auto';
        e.target.style.height = e.target.scrollHeight + 'px';
      }"
      x-bind:class="preview ? 'hidden' : 'block'" name="{{ $name }}" id="{{ $name }}" placeholder="{{ $placeholder ?? '' }}"
      class="{{ $error ? 'border-red-600' : '' }} relative z-10 block w-full resize-none overflow-hidden border-gray-200 bg-transparent text-sm leading-5 text-gray-700 ring-primary-600 selection:bg-primary-600 selection:text-white">{{ old($name, $value) }}</textarea>

    <template x-if="preview">
      <div x-data="{
          loading: true,
          html: '',
          error: '',
          async load() {
              try {
                  console.log(this.$refs.textarea)
                  this.html = (await window.axios.post('/markdown/preview?type={{ $type }}', { markdown: this.$refs.textarea.value })).data.html;
              } catch (e) {
                  this.error = e.response?.data.message || e.message;
                  window.toast.error(this.error);
              } finally {
                  this.loading = false;
              }
          },
          get message() {
              return this.loading ? 'Sedang memuat kontent' : this.error
          }
      }" x-init="load" class="bg-gray-200">
        <template x-if="message">
          <div class="h-[116px] border border-gray-200 bg-gray-50 p-3">
            <p class="flex h-full items-center justify-center px-3 text-center text-xl font-light" x-text="message"></p>
          </div>
        </template>
        <template x-if="!message">
          <div class="prose min-h-[116px] max-w-none border border-gray-200 bg-white p-3" x-html="html">
          </div>
        </template>
      </div>
    </template>
  </div>

  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</x-inputs.wrapper>

