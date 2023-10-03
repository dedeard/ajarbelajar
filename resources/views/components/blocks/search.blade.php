<template x-if="$store.searchStore.open">
  <div x-data="search" class="fixed inset-0 z-50 bg-black bg-opacity-50">
    <div class="relative flex justify-center lg:container lg:py-14">
      <span x-on:click="$store.searchStore.toggleOpen(false)" class="fixed bottom-0 left-0 right-0 top-0"></span>
      <div class="relative z-10 flex max-h-screen w-full max-w-5xl flex-col overflow-hidden bg-white shadow-xl lg:max-h-96 lg:rounded-lg">
        <div class="min-h-16 relative flex w-full bg-white">
          <div :class="focus ? 'text-primary-600' : 'text-gray-400'"
            class="pointer-events-none absolute flex h-full items-center justify-center px-4 text-xl leading-none">
            <i class="ft ft-search"></i>
          </div>
          <input x-ref="input" x-model.trim="input"
            class="block h-16 w-full flex-1 border-0 bg-transparent pl-12 pr-3 text-xl leading-none text-gray-500 placeholder-gray-300 transition-colors focus:text-gray-700 focus:outline-none focus:ring-0"
            placeholder="Apa yang anda cari?" x-on:focus="focus = true" x-on:blur="focus = false" />
          <template x-if="input">
            <button x-on:click="reset"
              class="my-auto flex h-full w-12 cursor-pointer items-center justify-center text-xl leading-none transition-colors hover:bg-gray-50">
              <i class="ft ft-x"></i>
            </button>
          </template>
          <div class="my-auto h-3/5 border-l border-gray-200"></div>
          <button x-on:click="$store.searchStore.toggleOpen(false)"
            class="my-auto flex h-full cursor-pointer items-center justify-center px-4 text-sm font-semibold leading-none text-red-600 transition-colors hover:bg-gray-50">Close</button>
        </div>

        <template x-if="logging">
          <p class="leading-1 bg-gray-200 px-4 py-1 text-sm text-gray-500" x-text="logging"></p>
        </template>
        <template x-if="!logging && queryResult &&  input.length > 1 && searchResults.length">
          <p class="leading-1 bg-gray-200 px-4 py-1 text-sm text-gray-500">
            Hasil dari : <span class="font-semibold text-gray-700" x-text="queryResult"></span>
          </p>
        </template>

        <template x-if="searchResults.length">
          <div class="custom-chrome-scrollbar flex max-h-full flex-col overflow-y-auto bg-white">
            <template x-for="(item, i) in searchResults" :key="i">
              <a :href="'{{ route('lessons.show', '__slug__') }}'.replace('__slug__', item.slug)"
                class="group block cursor-pointer bg-gray-100 px-4 hover:bg-white">
                <div class="last:border-b-5 flex border-b py-4">
                  <div class="flex items-center">
                    <div class="block">
                      <img :src="item.cover_url" :alt="item.title" class="h-7 rounded" />
                    </div>
                  </div>
                  <div class="flex flex-1 flex-col justify-center px-3">
                    <h3 class="font-semibold text-gray-700" x-html="item.title"></h3>
                    <p class="m-0 mt-2 flex items-center p-0 text-xs font-semibold">
                      <span class="block pr-1 leading-none text-gray-500">by</span>
                      <span class="block leading-none text-gray-700" x-html="item.author"></span>
                    </p>
                  </div>
                  <div class="flex items-center">
                    <span class="text-sm text-gray-500" x-html="item.category"></span>
                  </div>
                </div>
              </a>
            </template>
          </div>
        </template>

        <template x-if="queryResult && !searchResults.length && input.length > 1">
          <div class="flex max-h-full flex-col overflow-y-auto bg-gray-100 first:block">
            <div class="py-16 text-center">
              <p class="text-gray-700">TIDAK ADA HASIL DARI</p>
              <h3 class="text-2xl font-semibold text-primary-600" x-text="queryResult"></h3>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

