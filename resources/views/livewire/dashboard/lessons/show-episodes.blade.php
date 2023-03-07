<div>
  @if (session()->has('error'))
    <div class="border-l-4 border-primary-600 bg-primary-100 px-3 py-4 text-primary-600">
      {{ session('error') }}
    </div>
  @endif
  <input type="text" id="index" wire:model="index" class="hidden" />
  <ul id="sortable">
    @foreach ($episodes as $episode)
      <livewire:dashboard.lessons.episode-list :wire:key="'episode-'.$episode->id" :episode="$episode" />
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
