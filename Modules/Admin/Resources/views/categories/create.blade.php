<x-admin::layouts.main title="Buat Kategori Baru">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Buat Kategori Baru</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.categories.index') }}"
            class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="post">
          @csrf
          <x-admin::input name="name" label="Nama*" />
          <x-admin::textarea name="description" label="Deskripsi" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Kategori
              Baru</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
