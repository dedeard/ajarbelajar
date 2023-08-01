<x-admin::layouts.main title="Buat peran baru">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Buat Peran Baru</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.roles.index') }}"
            class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.roles.store') }}" method="post">
          @csrf

          <x-admin::input name="name" label="Nama Peran" />
          <x-admin::input name="display_name" label="Nama Tampilan Peran" />
          <x-admin::textarea name="description" label="Deskripsi Peran" />

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Peran
              Baru</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
