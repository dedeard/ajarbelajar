<x-app-layout dashboard title="Edit Password" header="Edit Password">
  <div class="container p-3">
    <form class="border bg-white" method="POST">
      @csrf
      @method('PUT')
      <x-alert />
      <div class="px-3 py-5">
        <x-input-wrap label="Password baru">
          <x-input name="new_password" placeholder="Password baru"
            type="password" />
        </x-input-wrap>
        <x-input-wrap label="Password saat ini">
          <x-input name="current_password" placeholder="Password saat ini"
            type="password" />
        </x-input-wrap>
      </div>
      <div class="border-t p-3">
        <x-button class="w-24" value="Simpan" />
      </div>
    </form>
  </div>
</x-app-layout>
