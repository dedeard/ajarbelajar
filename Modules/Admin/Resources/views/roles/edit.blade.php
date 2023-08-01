<x-admin::layouts.main title="Edit peran">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Edit Peran</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.roles.index') }}"
            class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.roles.update', $role->id) }}"
          method="post">
          @csrf
          @method('PUT')

          <x-admin::input name="name" label="Nama Peran"
            value="{{ $role->name }}" />
          <x-admin::input name="display_name" label="Nama Tampilan Peran"
            value="{{ $role->display_name }}" />
          <x-admin::textarea name="description" label="Deskripsi Peran"
            value="{{ $role->description }}" />

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Edit Role</button>
          </div>
        </form>
      </div>
    </div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Izin Peran dari {{ $role->display_name }}</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table-hover table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($permissions as $permission)
              <tr>
                <td>{{ $permission->display_name }}</td>
                <td>{{ $permission->description }}</td>
                <td class="py-0 text-center align-middle">
                  <a href="{{ route('admin.roles.toggle_sync_permission', [$role->id, $permission->id]) }}"
                    class="btn btn-sm btn-block {{ $role->hasPermission($permission->id) ? 'btn-danger' : 'btn-primary' }}">
                    {{ $role->hasPermission($permission->id) ? 'Cabut Izin' : 'Beri Izin' }}
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
