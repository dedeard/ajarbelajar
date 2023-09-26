<x-admin::layouts.main title="Buat admin baru">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Buat Admin Baru</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.admins.store') }}" method="post">
          @csrf
          <x-admin::input name="name" label="Nama Admin" />
          <x-admin::input name="email" label="Email Admin" type="email" />
          <x-admin::input name="password" label="Password" type="password" />
          <x-admin::select name="role_id" label="Peran" placeholder="Pilih Peran Admin" :options="$roleOptions" :selected="null" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Admin
              Baru</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
