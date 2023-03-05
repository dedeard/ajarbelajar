<x-dashboard-layout>
  <div class="container p-3">
    <form class="mb-3 rounded border-b-4 border-primary-600 bg-white shadow" method="POST">
      @csrf
      @method('PUT')
      <div class="border-b px-3 py-5">
        <h3 class="text-xl font-semibold">Edit Profil</h3>
      </div>
      <div class="px-3 py-5">
        <x-input-wrap label="Nama">
          <x-input name="name" placeholder="Nama kamu" value="{{ Auth::user()->name }}" />
        </x-input-wrap>
        <x-input-wrap label="Username">
          <x-input name="username" placeholder="Username" value="{{ Auth::user()->username }}" />
        </x-input-wrap>
        <x-input-wrap label="Website">
          <x-input name="website" placeholder="https://example.com" value="{{ Auth::user()->website }}" />
        </x-input-wrap>
        <x-input-wrap label="Bio">
          <x-input name="bio" type="textarea" value="{{ Auth::user()->bio }}" />
        </x-input-wrap>
      </div>
      <div class="border-t p-3">
        <x-button class="w-24" value="Simpan" />
      </div>
    </form>
  </div>
</x-dashboard-layout>
