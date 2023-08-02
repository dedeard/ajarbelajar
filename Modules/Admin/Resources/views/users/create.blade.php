<x-admin::layouts.main title="Buat pengguna baru">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Buat Pengguna Baru</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.users.index') }}"
            class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="post">
          @csrf
          <x-admin::input name="name" label="Nama*" />
          <x-admin::input name="username" label="Username*" />
          <x-admin::input name="email" label="Email*" />
          <x-admin::input name="password" label="Password*" type="password" />
          <x-admin::input name="website" label="Website" />
          <x-admin::textarea name="bio" label="Bio" />
          <x-admin::checkbox name="email_verified" label="Verifikasi Email" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Buat Pengguna
              Baru</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
