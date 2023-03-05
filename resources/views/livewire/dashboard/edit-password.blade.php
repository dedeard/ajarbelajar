<form x-data wire:submit.prevent="submit" class="mb-3 rounded border-b-4 border-primary-600 bg-white shadow">
  <x-alert />
  <div class="border-b px-3 py-5">
    <h3 class="text-xl font-semibold">Edit Password</h3>
  </div>
  <div class="px-3 py-5">
    <x-input-wrap label="Password baru">
      <x-input model="new_password" placeholder="Password baru" type="password" />
    </x-input-wrap>
    <x-input-wrap label="Password saat ini">
      <x-input model="current_password" placeholder="Password saat ini" type="password" />
    </x-input-wrap>
  </div>
  <div class="border-t p-3">
    <x-button class="w-24" value="Simpan" />
  </div>
</form>
