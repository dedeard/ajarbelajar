<x-app-layout title="Belajar, Berbagi, Berkontribusi">
  <div class="container mb-3 p-3">
    <div class="mb-3 overflow-hidden bg-cover bg-fixed" style="background-image: url({{ asset('img/hero.jpg') }})">
      <div class="bg-opacity-30 bg-gradient-to-r from-primary-700 to-transparent p-4">
        <div class="flex flex-col items-center justify-center py-16 text-center">
          <h1 class="mb-3 text-2xl font-bold text-white md:text-3xl lg:text-4xl">Belajar, Berbagi, Berkontribusi.</h1>
          <p class="max-w-lg text-gray-100 md:text-lg">
            Pengembangan kemampuan diri dan kualitas pendidikan Indonesia, dimulai dari sini!
          </p>
        </div>
      </div>
    </div>
  </div>


  <div class="container mb-3 p-3">
    <h3 class="text-xl font-semibold uppercase tracking-wider">Pelajaran terbaru</h3>
    <div class="grid grid-cols-1 gap-3 py-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($lessons as $lesson)
        <x-lesson-list :lesson="$lesson" :user="Auth::user()" />
      @endforeach
    </div>
    <div class="py-3 text-center">
      <a href="{{ route('lessons.index') }}"
        class="inline-block bg-primary-600 px-4 py-2 text-sm uppercase text-white hover:bg-primary-700">
        Lihat lebih banyak Pelajaran
      </a>
    </div>
  </div>

  <div class="container p-3">
    <h3 class="text-xl font-semibold uppercase tracking-wider">Kategori populer</h3>
    <div class="grid grid-cols-1 gap-3 py-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($categories as $category)
        <x-category-list :category="$category" />
      @endforeach
    </div>
    <div class="py-3 text-center">
      <a href="{{ route('categories.index') }}"
        class="inline-block bg-primary-600 px-4 py-2 text-sm uppercase text-white hover:bg-primary-700">
        Lihat lebih banyak kategori
      </a>
    </div>
  </div>

  <div class="container p-3">
    <h3 class="text-xl font-semibold uppercase tracking-wider">Pengguna baru</h3>
    <div class="grid grid-cols-1 gap-3 py-3 md:grid-cols-2 xl:grid-cols-4">
      @foreach ($users as $user)
        <x-user-list :user="$user" />
      @endforeach
    </div>
    <div class="py-3 text-center">
      <a href="{{ route('users.index') }}" class="inline-block bg-primary-600 px-4 py-2 text-sm uppercase text-white hover:bg-primary-700">
        Lihat lebih banyak pengguna
      </a>
    </div>
  </div>

</x-app-layout>
