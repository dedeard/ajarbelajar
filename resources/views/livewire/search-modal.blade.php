<div x-data="{
    focus: false
}" x-init="$watch('$store.searchModal.show', (val) => {
    if (val) {
        document.getElementById('search').focus()
    }
})" id="backdrop"
  class="fixed inset-0 z-50 hidden bg-black bg-opacity-50"
  :class="$store.searchModal.show ? '!block' : ''">
  <div class="relative flex justify-center lg:container lg:py-14">
    <div
      x-on:click.stop.outside="(e) => {
            if(e.target === document.getElementById('backdrop')) {
                this.Alpine.store('searchModal').close()
            }
        }"
      class="relative z-10 flex max-h-screen w-full max-w-5xl flex-col overflow-hidden bg-white shadow-xl lg:max-h-96 lg:rounded-lg">
      <div class="min-h-16 relative flex w-full bg-white">
        <div :class="focus ? 'text-primary-600' : 'text-gray-400'"
          class="absolute flex h-full items-center justify-center px-4 text-xl leading-none">
          <i class="ft ft-search"></i>
        </div>
        <input wire:model="input" id="search" name="search" type="text"
          autocomplete="off"
          class="block h-16 w-full flex-1 appearance-none !border-none bg-transparent pl-12 pr-3 text-xl font-semibold leading-none text-gray-500 placeholder-gray-300 !outline-none !ring-0 transition-colors focus:text-gray-700"
          placeholder="Apa yang anda cari?" @focus="focus = true"
          @blur="focus = false" />
        @if ($input)
          <button wire:click="resetInput"
            class="my-auto flex h-full w-12 cursor-pointer items-center justify-center text-xl leading-none transition-colors hover:bg-gray-50">
            <i class="ft ft-x"></i>
          </button>
        @endif
        <div class="my-auto h-3/5 border-l"
          :class="focus ? 'border-primary-600' : 'border-gray-200'"></div>
        <button x-on:click="$store.searchModal.close()"
          class="my-auto flex h-full cursor-pointer items-center justify-center px-4 text-sm font-semibold leading-none text-red-600 transition-colors hover:bg-gray-50">Close</button>
      </div>
      @if (count($results))
        @if (strlen($queryResult) > 1 && strlen($input) > 1)
          <p class="leading-1 bg-gray-200 px-4 py-1 text-sm text-gray-500">
            Hasil dari : <span
              class="font-semibold text-gray-700">{{ $queryResult }}</span>
          </p>
        @endif
        <div
          class="custom-chrome-scrollbar flex max-h-full flex-col overflow-y-auto bg-white">
          @foreach ($results as $result)
            <a href="{{ route('lessons.show', $result['slug']) }}"
              class="group block cursor-pointer bg-gray-100 px-4 hover:bg-white">
              <div class="last:border-b-5 flex border-b py-4">
                <div class="flex items-center">
                  <div class="block">
                    <img src="{{ $result['cover_url'] }}"
                      alt="{{ $result['title'] }}" class="h-7 rounded" />
                  </div>
                </div>
                <div class="flex flex-1 flex-col justify-center px-3">
                  <h3 class="font-semibold text-gray-700">
                    {!! $result['_formatted']['title'] !!}</h3>
                  <p
                    class="m-0 mt-2 flex items-center p-0 text-xs font-semibold">
                    <span
                      class="block pr-1 leading-none text-gray-500">by</span>
                    <span
                      class="block leading-none text-gray-700">{!! $result['_formatted']['author'] !!}</span>
                  </p>
                </div>
                <div class="flex items-center">
                  <span
                    class="text-sm text-gray-500">{!! $result['_formatted']['category'] !!}</span>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      @endif

      @if (count($results) === 0 && strlen($queryResult) > 1 && strlen($input) > 1)
        <div
          class="flex max-h-full flex-col overflow-y-auto bg-gray-100 first:block">
          <div class="py-16 text-center">
            <p class="text-gray-700">TIDAK ADA HASIL DARI</p>
            <h3 class="text-2xl font-semibold text-primary-600">
              {{ $queryResult }}</h3>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
