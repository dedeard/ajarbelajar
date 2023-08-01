<x-admin::layouts.main title="Daftar peran">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Daftar Peran</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.roles.create') }}"
            class="btn btn-sm btn-primary">Buat Peran Baru</a>
        </div>
      </div>
      <!-- ./card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Dibuat pada</th>
              <th>Diedit pada</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($roles as $role)
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{ $role->id }}</td>
                <td>{{ $role->display_name }}</td>
                <td>{{ $role->created_at->format('d F Y') }}</td>
                <td>{{ $role->updated_at->format('d F Y') }}</td>
                <td class="py-0 text-center align-middle">
                  @if (!$role->is_protected)
                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                      class="btn btn-default btn-sm" title="Edit peran">
                      <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-danger btn-sm btn-icon"
                      title="Hapus peran"
                      delete-confirm="#form-delete-role-{{ $role->id }}">
                      <i class="fas fa-trash"></i>
                    </button>
                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                      method="post" id="form-delete-role-{{ $role->id }}">
                      @csrf
                      @method('delete')
                    </form>
                  @endif
                </td>
              </tr>
              <tr class="expandable-body d-none">
                <td colspan="5">
                  <p>
                    {{ $role->description }}
                  </p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
  </div>
</x-admin::layouts.main>
