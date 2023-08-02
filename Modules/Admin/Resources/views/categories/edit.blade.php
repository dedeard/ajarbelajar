<x-admin::layouts.main title="Edit Kategori">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Edit Kategori</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.categories.index') }}"
            class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.categories.update', $category->id) }}"
          method="post">
          @csrf
          @method('put')
          <x-admin::input name="name" label="Nama*" :value="$category->name" />
          <x-admin::textarea name="description" label="Deskripsi"
            :value="$category->description" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan
              Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
