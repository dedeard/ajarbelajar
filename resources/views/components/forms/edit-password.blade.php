<turbo-frame id="form.update-password">
  <x-alert />
  <form class="border bg-white" method="POST" action="{{ route('settings.update-password') }}">
    @csrf
    <h2 class="border-b p-3 pt-4 font-semibold uppercase">Pengaturan Password</h2>
    <div class="px-3 py-5">
      <x-input.wrapper label="Password baru">
        <x-input.password name="new_password" placeholder="Password baru" />
      </x-input.wrapper>
      <x-input.wrapper label="Password saat ini">
        <x-input.password name="current_password" placeholder="Password saat ini" />
      </x-input.wrapper>
    </div>
    <div class="border-t p-3">
      <x-input.button class="w-24" value="Simpan" />
    </div>
  </form>
</turbo-frame>
