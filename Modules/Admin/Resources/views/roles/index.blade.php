<x-admin::layouts.main title="Daftar peran">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Role</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.roles.create') }}"
            class="btn btn-sm btn-primary">Buat Role</a>
        </div>
      </div>
      <table class="table-hover table">
        <thead>
          <tr>
            <th>Nama</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $role)
            <tr>
              <td class="align-middle">{{ $role->name }}</td>
              <td class="py-0 text-center align-middle">
                @if (!$role->is_protected)
                  <a href="{{ route('admin.roles.edit', $role->id) }}"
                    class="btn btn-default btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-danger btn-sm btn-icon" title="Delete"
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
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</x-admin::layouts.main>
