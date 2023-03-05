@props(['container' => false])

{{-- r --}}
<footer class="mt-auto border-t border-gray-200 bg-white">
  <div class="{{ $container ? 'container' : '' }}">
    <div class="grid grid-cols-1 gap-3 py-14 md:grid-cols-3">
      <div class="p-3 text-center md:text-left">
        <x-svg.brand class="mx-auto h-10 md:mx-0" />
        <p class="py-3 text-sm leading-none tracking-wider">BELAJAR, BERBAGI, BERKONTRIBUSI</p>
      </div>
      <div class="p-3 text-center md:text-left">
        <div class="mb-2">
          <a href="#" class="text-sm hover:text-primary-600">Tantang AjarBelajar</a>
        </div>
        <div class="mb-2">
          <a href="#" class="text-sm hover:text-primary-600">Tantang MiniTutor</a>
        </div>
        <div>
          <a href="#" class="text-sm hover:text-primary-600">F . A . Q</a>
        </div>
      </div>
      <div class="p-3 text-center md:text-right">
        <a href="https://www.instagram.com/dedeard.js" target="_blank" rel="noreferrer"
          class="toggle-color inline-flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm"><i class="ft ft-facebook"></i></a>
        <a href="https://www.instagram.com/dedeard.js" target="_blank" rel="noreferrer"
          class="toggle-color ml-3 inline-flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm"><i
            class="ft ft-instagram"></i></a>
        <a href="https://www.youtube.com/channel/UC_RqkZkVSmRIKNnj_5QPv5Q" target="_blank" rel="noreferrer"
          class="toggle-color ml-3 inline-flex h-9 w-9 items-center justify-center rounded-full p-0 text-sm"><i
            class="ft ft-youtube"></i></a>
      </div>
    </div>
  </div>
  <div class="bg-gray-100 py-6">
    <p class="text-center text-xs">
      © {{ now()->year }} All Right Reserved AjarBelajar - By
      <a href="https://dedeard.my.id" class="text-primary-600" target="_blank" rel="noreferrer">Dede ariansya</a>
    </p>
  </div>
</footer>
