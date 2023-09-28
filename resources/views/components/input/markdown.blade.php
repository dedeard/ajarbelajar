@props([
    'name' => '',
    'label' => '',
    'value' => '',
    'help' => '',
    'disabled-tools' => [],
    'type' => 'minimal',
    'error' => $errors->first($name),
])

<x-input.wrapper label="{{ $label }}" for="{{ $name }}">
  <div x-data="markdown" class="border bg-white">
    <div class="flex">
      <button type="button"
        class="block items-center justify-center border-b-2 bg-white px-4 pb-2 pt-3 text-xs font-bold uppercase tracking-widest text-gray-500"
        :class="!preview ? '!border-primary-600 !text-gray-700' : ''" x-on:click="preview = false">Markdown</button>
      <button type="button"
        class="block items-center justify-center border-b-2 bg-white px-4 pb-2 pt-3 text-xs font-bold uppercase tracking-widest text-gray-500"
        :class="preview ? '!border-primary-600 !text-gray-700' : ''" x-on:click="preview = true">Preview</button>
      <span class="block flex-1 border-b-2"></span>
    </div>

    <div :class="preview ? '!hidden' : ''">
      <div x-data="{ disableds: @js($disabledTools) }" class="flex flex-wrap items-center justify-center border-b bg-gray-100 px-1 pt-1">
        <template x-for="(command) in Object.keys(commandMap)" :key="command">
          <template x-if="!disableds?.includes(command)">
            <button type="button" class="mb-1 mr-1 flex h-7 w-7 items-center justify-center bg-white p-0 text-sm hover:bg-primary-100"
              x-on:click="formatText(command)" :title="commandMap[command].label">
              <i :class="commandMap[command].icon"></i>
            </button>
          </template>
        </template>
      </div>
      <label class="relative flex w-full pb-24">
        <ul class="w-full select-none break-words text-sm leading-5">
          <template x-for="(line, i) in lines" :key="i">
            <li class="relative w-full break-words pl-3 pr-10" :class="activeLineNumber === i ? 'bg-primary-100' : ''">
              <span x-text="i + 1" class="absolute bottom-0 left-0 top-0 w-10 bg-gray-100 text-center text-xs leading-5"
                :class="activeLineNumber === i ? 'text-primary-700' : 'text-gray-700'"></span>
              <span class="opacity-0" x-text="line ? line : '-'"></span>
            </li>
          </template>
        </ul>
        <textarea x-ref="textarea" name="{{ $name }}" id="{{ $name }}"
          class="absolute bottom-0 left-0 right-0 top-0 z-10 block h-auto w-full resize-none overflow-visible !border-0 bg-transparent p-0 pl-10 text-sm leading-5 text-gray-700 !ring-0 selection:bg-primary-600 selection:text-white">{{ $value ?? old($name) }}</textarea>
      </label>
    </div>

    <template x-if="preview">
      <div x-data="{
          loading: true,
          html: '',
          error: '',
          async load() {
              try {
                  this.html = (await window.axios.post('/markdown/preview?type={{ $type }}', {
                      markdown: this.$refs.textarea.value
                  })).data.html;
                  this.loading = false
              } catch (e) {
                  this.error = e.response?.data.message || e.message
                  window.fire.error(this.error)
              }
          }
      }" x-init="load" class="bg-gray-300">
        <template x-if="loading || error">
          <div class="p-3">
            <div class="border bg-gray-50 p-5">
              <p class="px-3 py-8 text-center text-xl font-light empty:hidden md:text-2xl" x-text="loading ? 'Sedang memuat kontent' : ''">
              </p>
              <p class="px-3 py-8 text-center text-xl font-light empty:hidden md:text-2xl" x-text="error"></p>
            </div>
          </div>
        </template>
        <div class="prose max-w-none bg-white p-3 empty:hidden" x-html="html"></div>
      </div>
    </template>
  </div>

  @if ($error)
    <span class="block text-xs text-red-900">{{ $error }}</span>
  @elseif($help)
    <span class="block text-xs">{{ $help }}</span>
  @endif
</x-input.wrapper>
