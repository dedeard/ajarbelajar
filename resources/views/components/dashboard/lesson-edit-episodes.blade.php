@props(['lesson'])

<div x-data="{ episodes: @js(
    $lesson->episodes()->orderBy('index')->get()
) }">
  <div x-data="{
      name: '',
      fileInput: null,
      uploading: false,
      progress: 0,
      get message() {
          return (this.progress < 100) ? `Sedang Diunggah: ${this.progress}%` : 'Video sedang diproses'
      },
      async onChange(e) {
          this.uploading = true
          const onUploadProgress = (e) => {
              this.progress = Math.round((e.loaded * 100) / e.total);
          }
          try {
              const [file] = e.target.files
              if (file) {
                  const formData = new FormData();
                  formData.append('video', file);
                  this.name = file ? file.name : ''
                  const { data } = await window.axios.post('{{ route('dashboard.lessons.store.episode', ['lesson' => $lesson->id]) }}', formData, { onUploadProgress });
                  this.episodes = [...this.episodes, data.episode]
                  window.fire.success('Berhasil membuat episode.')
              }
          } catch (err) {
              window.fire.error(err.response?.data.message || err.message)
          }
          this.fileInput = null;
          this.uploading = false
      },
      onComplete() {
          this.name = ''
          this.uploading = false
          this.progress = 0
      }
  }" class="border bg-white">
    <div class="flex min-h-[100px] w-full p-3">
      <div class="relative flex flex-1 flex-col border border-dashed bg-gray-50 p-3">
        <p class="m-auto text-center text-sm leading-none" x-text="name || 'Klik disini untuk mengupload episode'">
        </p>
        <p class="text-center text-sm" x-show="uploading" x-text="message"></p>
        <input type="file" accept="video/*" x-model="fileInput" x-on:change="onChange"
          class="absolute left-0 top-0 z-10 block h-full w-full opacity-0" />
      </div>
    </div>
  </div>

  <template x-if="episodes">
    <div x-data="{
        initSortable() {
            window.Sortable.create(this.$refs.sortable, {
                direction: 'vertical',
                handle: '.handle',
                chosenClass: 'bg-gray-100',
                ghostClass: 'opacity-70',
                onEnd: async () => {
                    const index = []
                    for (let list of this.$refs.sortable.children) {
                        if (list.tagName == 'LI') {
                            index.push(Number(list.getAttribute('data-id')))
                        }
                    }
                    try {
                        await axios.put('{{ route('dashboard.lessons.update.index', $lesson->id) }}', { index })
                        window.fire.success('Index telah diupdate.')
                    } catch (err) {
                        window.fire.error(err.response?.data.message || err.message)
                    }
                },
            })
        }
    }" x-init="initSortable" class="border border-t-0 bg-white">
      <ul x-ref="sortable">
        <template x-for="episode in episodes" x-bind:key="episode.id">
          <li x-bind:data-id="episode.id" class="border-t first:border-t-0">
            <div class="flex items-center">
              <div class="handle flex flex-1 cursor-grab items-center py-3">
                <div class="flex items-center justify-center px-3">
                  <i class="ft ft-menu"></i>
                </div>
                <div class="flex flex-1 items-center">
                  <span class="block pr-3 text-sm font-semibold" x-text="episode.readable_second"></span>
                  <span class="block flex-1 text-sm" x-text="episode.title"></span>
                </div>
              </div>
              <div class="p-3">
                <a x-bind:href="`{{ route('dashboard.lessons.episode.edit', ['episode' => 'episode_id', 'lesson' => 'lesson_id']) }}`.replace('episode_id',
                    episode.id).replace('lesson_id', episode.lesson_id)"
                  class="block rounded-full bg-primary-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-primary-700">
                  Edit
                </a>
              </div>
            </div>
          </li>
        </template>
      </ul>
    </div>
  </template>
</div>
