@props(['noContainer' => false])

<footer class="mt-auto border-t border-gray-200 bg-white">
  <div class="{{ $noContainer ? '' : 'container' }}">
    <div class="grid grid-cols-1 gap-3 py-14 md:grid-cols-3">
      <div class="p-3 text-center md:text-left">
        <x-svg.brand class="mx-auto h-10 md:mx-0" />
        <p class="py-3 text-sm leading-none tracking-wider">BELAJAR, BERBAGI, BERKONTRIBUSI</p>
      </div>
      <div class="p-3 text-center md:text-left">
        <div class="mb-2">
          <a href="#" class="text-sm hover:text-primary-600">
            Tentang ajarbalajar
          </a>
        </div>
        <div class="mb-2">
          <a href="#" class="text-sm hover:text-primary-600">
            Kebijakan pribadi
          </a>
        </div>
        <div>
          <a href="#" class="text-sm hover:text-primary-600">
            F . A . Q
          </a>
        </div>
      </div>
      <div class="p-3 text-center md:text-right">
        <a href="#" target="_blank" rel="noreferrer" aria-label="Facebook"
          class="inline-flex h-9 w-9 items-center justify-center rounded-full border bg-gray-100 p-0 text-sm hover:bg-gray-200">
          <i class="ft ft-facebook"></i>
        </a>
        <a href="#" target="_blank" rel="noreferrer" aria-label="Instagram"
          class="ml-3 inline-flex h-9 w-9 items-center justify-center rounded-full border bg-gray-100 p-0 text-sm hover:bg-gray-200">
          <i class="ft ft-instagram"></i>
        </a>
        <a href="#" target="_blank" rel="noreferrer" aria-label="YouTube"
          class="ml-3 inline-flex h-9 w-9 items-center justify-center rounded-full border bg-gray-100 p-0 text-sm hover:bg-gray-200">
          <i class="ft ft-youtube"></i>
        </a>
      </div>
    </div>
  </div>
  <div class="bg-gray-100 py-6">
    <p class="text-center text-xs">
      © {{ now()->year }} All Right Reserved AjarBelajar - By{{ ' ' }}
      <a href="https://dedeard.my.id" class="text-primary-600" target="_blank" rel="noreferrer">
        Dede ariansya
      </a>
    </p>
  </div>
</footer>
