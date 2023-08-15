<div>
  @if (session()->has('error'))
    <div
      class="border-l-4 border-primary-600 bg-primary-100 px-3 py-4 text-primary-600">
      {{ session('error') }}
    </div>
  @endif
  @if (!count($episodes))
    <x-dashboard.blank>Untuk pelajaran ini, belum ada episode yang telah anda
      dibuat.</x-dashboard.blank>
  @else
    <div class="border bg-white">
      <input type="text" id="index" wire:model="index" class="hidden" />
      <ul id="sortable">
        @foreach ($episodes as $episode)
          <li data-id="{{ $episode->id }}" x-data="{
              open: false
          }"
            class="border-t">
            <div class="flex items-center">
              <div class="handle flex flex-1 cursor-grab items-center py-3">
                <div class="flex items-center justify-center px-3">
                  <i class="ft ft-menu"></i>
                </div>
                <div class="flex flex-1 items-center">
                  <span
                    class="block pr-3 text-sm font-semibold">{{ $episode->readable_second }}</span>
                  <span class="block flex-1 text-sm">
                    {{ $episode->title }}
                  </span>
                </div>
              </div>
              <div class="p-3">
                <a href="{{ route('dashboard.lessons.episode.edit', ['episode' => $episode->id, 'lesson' => $episode->lesson_id]) }}"
                  class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
                  Edit
                </a>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
      <script>
        (() => {
          const el = document.getElementById('sortable')
          const input = document.getElementById('index')

          const setInputValue = () => {
            const ids = []
            for (let list of el.children) {
              ids.push(list.getAttribute('data-id'))
            }
            @this.set('index', ids.join(','))
          }

          const init = () => {
            window.Sortable.create(el, {
              direction: 'vertical',
              handle: '.handle',
              chosenClass: 'bg-gray-100',
              ghostClass: 'opacity-70',
              onEnd() {
                setInputValue()
              },
            })
          }

          if (window.Sortable) {
            init()
          } else {
            window.onload = function() {
              init()
            }
          }
        })()
      </script>
    </div>
  @endif

</div>
