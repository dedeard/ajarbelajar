<li data-id="{{ $episode->id }}" x-data="{
    open: false
}" class="border-b first:border-t" @click.outside="open = false">
  <div class="flex items-center">
    <div class="handle flex h-12 cursor-grab items-center justify-center p-3">
      <i class="ft ft-menu"></i>
    </div>
    <div class="flex flex-1 cursor-pointer items-center overflow-hidden py-2">
      <span class="block px-2 text-sm font-semibold">{{ $duration }}</span>
      <div class="flex-1">
        <x-input model="episode_title" placeholder="Judul" />
      </div>
    </div>
    <div class="px-3">
      <x-button class="mr-2 !p-2" @click="open = !open">
        <i class="ft ft-play" x-show="!open"></i>
        <i class="ft ft-square" x-show="open"></i>
      </x-button>
      <x-button variant="red" class="!p-2" @click="$store.deleteConfirm($wire.destroy)">
        <i class="ft ft-trash"></i>
      </x-button>
    </div>
  </div>
  <template x-if="open">
    <video src="{{ $episode->video_url }}" controls autoplay class="block w-full"></video>
  </template>
</li>
