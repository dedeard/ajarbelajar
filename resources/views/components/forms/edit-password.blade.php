<turbo-frame id="form.update-password">
  <x-ui.alert />
  <form class="border bg-white" method="POST" action="{{ route('settings.update-password') }}">
    @csrf
    <h2 class="border-b p-3 pt-4 font-semibold uppercase">Pengaturan Password</h2>
    <div class="px-3 py-5">
      <x-inputs.wrapper label="Password baru">
        <x-inputs.password name="new_password" placeholder="Password baru" />
      </x-inputs.wrapper>
      <x-inputs.wrapper label="Password saat ini">
        <x-inputs.password name="current_password" placeholder="Password saat ini" />
      </x-inputs.wrapper>
    </div>
    <div class="border-t p-3">
      <x-inputs.button class="w-24" value="Simpan" />
    </div>
  </form>
</turbo-frame>
