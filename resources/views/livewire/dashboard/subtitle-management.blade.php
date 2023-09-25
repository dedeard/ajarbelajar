<div>
  <div class="mb-3 border bg-white">
    <div class="border-b p-3">
      <h3 class="font-bold uppercase">Buat Subtitle</h3>
    </div>
    @if (session()->has('create_message'))
      <div class="bg-primary-100 p-3">
        {{ session('create_message') }}
      </div>
    @endif
    <form wire:submit.prevent="save" enctype="multipart/form-data">
      <div class="border-b p-3">
        <x-input-wrap label="Bahasa">
          <x-input name="language" type="select" model="language" title="Bahasa"
            placeholder="Bahasa">
            <option value="" selected>Pilih</option>
            @foreach ($languages as $lang)
              <option value="{{ $lang['code'] }}">{{ $lang['code'] }} :
                {{ $lang['name'] }}</option>
            @endforeach
          </x-input>
        </x-input-wrap>

        <x-input-wrap label="Subtitle">
          <x-input type="file" name="file" model="file" title="Subtitle" :placeholder="$file ? $file->getClientOriginalName() : 'Subtitle'" />
        </x-input-wrap>
      </div>
      <div class="p-3">
        <x-button value="Buat Subtitle" />
      </div>
    </form>
  </div>

  <div class="mb-3 bg-white">
    <div class="border border-b-0 p-3">
      <h3 class="font-bold uppercase">Daftar Subtitle</h3>
    </div>
    @if (session()->has('delete_message'))
      <div class="bg-primary-100 p-3">
        {{ session('delete_message') }}
      </div>
    @endif
    <table class="w-full table-auto">
      <thead>
        <tr>
          <th class="w-[80px] border">Kode</th>
          <th class="border px-3 text-left">Bahasa</th>
          <th class="w-[100px] border">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($subtitles as $sub)
          <tr>
            <td class="border text-center">{{ $sub->code }}</td>
            <td class="border px-3">{{ $sub->name }}</td>
            <td class="border py-1 text-center">
              <button
                x-on:click="$store.deleteConfirm(() => $wire.remove({{ $sub->id }}))"
                class="inline-block rounded-full bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-red-700">
                Hapus
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
