<turbo-frame id="form.update-profile">
  <x-ui.alert />
  <script>
    window.Alpine?.store('authStore')?.set(@js(Auth::user()))
  </script>
  <form class="border bg-white" method="POST" enctype="multipart/form-data" action="{{ route('settings.update-profile') }}">
    @csrf
    <h2 class="border-b p-3 pt-4 font-semibold uppercase">Pengaturan Profil</h2>
    <div class="px-3 py-5">
      <div class="flex">
        <div class="w-32">
          <div x-data="{
              file: null,
              url: '{{ Auth::user()->avatar_url }}',
              previewImage: function(event) {
                  const file = event.target.files[0];
                  this.file = file;
                  this.url = URL.createObjectURL(file);
              },
              triggerInput: function() {
                  this.$refs.fileInput.click();
              }
          }" class="relative h-32 w-32 overflow-hidden rounded-full border border-gray-300 bg-gray-200">
            <template x-if="!url">
              <x-ui.avatar :name="Auth::user()->name" class="block h-full w-full" />
            </template>
            <template x-if="url">
              <img class="block h-full w-full object-cover" :src="url" alt="User Avatar">
            </template>

            <input x-ref="fileInput" name="avatar" type="file" x-on:change="previewImage" accept="image/*" class="hidden" />
            <button type="button" x-on:click="triggerInput"
              class="absolute left-0 top-0 flex h-full w-full bg-gray-600/50 p-0 font-bold text-white opacity-0 transition-opacity duration-300 hover:opacity-100">
              <span class="m-auto block uppercase tracking-wider">Ubah</span>
            </button>
          </div>

        </div>
        <div class="flex-1 pl-3">
          <x-inputs.wrapper label="Nama">
            <x-inputs.text name="name" placeholder="Nama kamu" value="{{ Auth::user()->name }}" />
          </x-inputs.wrapper>
          <x-inputs.wrapper label="Username">
            <x-inputs.text name="username" placeholder="Username" value="{{ Auth::user()->username }}" />
          </x-inputs.wrapper>
        </div>
      </div>
      <x-inputs.wrapper label="Website">
        <x-inputs.text name="website" placeholder="https://example.com" value="{{ Auth::user()->website }}" />
      </x-inputs.wrapper>
      <x-inputs.wrapper label="Bio">
        <x-inputs.textarea name="bio" placeholder="Bio" value="{{ Auth::user()->bio }}" />
      </x-inputs.wrapper>
    </div>
    <div class="border-t p-3">
      <x-inputs.button value="Simpan" />
    </div>
  </form>
</turbo-frame>
