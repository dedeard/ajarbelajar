@props(['episode'])

<div class="mb-3 border bg-white">
  <div class="border-b p-3">
    <h3 class="font-bold uppercase">Buat Subtitle</h3>
  </div>
  <form method="POST" action="{{ route('subtitles.store', $episode->id) }}" enctype="multipart/form-data">
    <div class="border-b p-3">
      <x-inputs.select name="language" title="Bahasa" placeholder="Bahasa">
        <option value="" selected>Pilih</option>
        @foreach (config('languages') as $lang)
          <option value="{{ $lang['code'] }}" @if (old('language') === $lang['code']) selected @endif>{{ $lang['code'] }} : {{ $lang['name'] }}
          </option>
        @endforeach
      </x-inputs.select>
      <x-inputs.file name="file" label="Subtitle" placeholder="Pilih file subtitle" />
    </div>
    <div class="p-3">
      <x-inputs.button value="Buat Subtitle" />
    </div>
  </form>
</div>

<div class="mb-3 bg-white">
  <div class="border border-b-0 p-3">
    <h3 class="font-bold uppercase">Daftar Subtitle</h3>
  </div>
  <table class="w-full table-auto">
    <thead>
      <tr>
        <th class="w-[80px] border">Kode</th>
        <th class="border px-3 text-left">Bahasa</th>
        <th class="w-[100px] border">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($episode->subtitles as $sub)
        <tr x-data>
          <td class="border text-center">{{ $sub->code }}</td>
          <td class="border px-3">{{ $sub->name }}</td>
          <td class="border py-1 text-center">
            <form method="POST" x-ref="formDeleteSubtitle" action="{{ route('subtitles.destroy', $sub->id) }}">
              @csrf
              @method('DELETE')
            </form>
            <button x-on:click="$store.deleteConfirm(() => Turbo.navigator.submitForm($refs.formDeleteSubtitle))"
              class="inline-block rounded-full bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-white hover:bg-red-700">
              Hapus
            </button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
