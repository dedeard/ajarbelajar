<x-dashboard-layout>
  <div class="container p-3">
    <div class="mb-3 rounded border-b-4 border-primary-500 bg-white shadow">
      <div class="flex items-center border-b px-3 py-5">
        <h3 class="flex-1 text-xl font-semibold">Daftar Artikel</h3>
        <div>
          <a href="{{ route('dashboard.articles.create') }}"
            class="block rounded-full bg-primary-600 px-4 py-2 text-sm text-white hover:bg-primary-700">
            Buat Artikel
          </a>
        </div>
      </div>
      <div class="grid grid-cols-3 border-b p-3 md:gap-3">
        <a href="{{ route('dashboard.articles.index') }}"
          class="@if ($tab === 'all') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Semua</a>
        <a href="{{ route('dashboard.articles.index', ['tab' => 'public']) }}"
          class="@if ($tab === 'public') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Publik</a>
        <a href="{{ route('dashboard.articles.index', ['tab' => 'draft']) }}"
          class="@if ($tab === 'draft') bg-primary-600 text-white @else hover:bg-gray-100 @endif block rounded p-3 text-center text-sm font-semibold leading-none md:text-base">Draf</a>
      </div>
    </div>
    @foreach ($articles as $article)
      <x-dashboard.post-list :post="$article" type="article" />
    @endforeach
    {{ $articles->links() }}
  </div>
</x-dashboard-layout>
