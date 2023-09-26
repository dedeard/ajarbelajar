<x-admin::layouts.main title="Edit Admin">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Edit Admin</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.admins.update', $admin->id) }}" method="post">
          @csrf
          @method('PUT')

          <x-admin::input name="name" label="Nama Admin" value="{{ $admin->name }}" />
          <x-admin::input name="email" label="Email Admin" type="email" value="{{ $admin->email }}" />
          <x-admin::input name="password" label="Password" type="password" />
          <x-admin::select name="role_id" label="Peran" placeholder="Pilih Peran Admin" :options="$roleOptions" :selected="$admin->role ? $admin->role->id : null" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Admin</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
