<div>
  <div class="border bg-white p-3">
    <form wire:submit.prevent="save" enctype="multipart/form-data">
      <x-input-wrap label="Bahasa">
        <x-input name="language" model="language" title="Bahasa"
          placeholder="Bahasa" />
      </x-input-wrap>

      <x-input-wrap label="Subtitle">
        <x-input type="file" name="file" model="file" title="Subtitle"
          placeholder="Subtitle" />
      </x-input-wrap>

      <x-button>Buat subtitle</x-button>
    </form>
  </div>
</div>
