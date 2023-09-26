<x-admin::layouts.main title="Daftar admin">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Daftar Admin</h3>
        <div class="my-auto ml-auto">
          @can('create admin')
            <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-primary">Buat Admin Baru</a>
          @endcan
        </div>
      </div>
      <!-- ./card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table">
          <thead>
            <tr>
              <th>Avatar</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Dibuat pada</th>
              <th>Diedit pada</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($admins as $admin)
              <tr>
                <td class="py-0 align-middle"><img src="{{ $admin->avatar_url }}" width="36px" alt="Avatar" class="avatar img-circle">
                </td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->created_at->format('d F Y') }}</td>
                <td>{{ $admin->updated_at->format('d F Y') }}</td>
                <td class="py-0 text-center align-middle">
                  @if (!$admin->role || ($admin->role && $admin->role->name !== 'super admin'))
                    @can('update admin')
                      <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn btn-default btn-sm" title="Edit admin">
                        <i class="fas fa-edit"></i>
                      </a>
                    @endcan
                    @can('delete admin')
                      <button class="btn btn-danger btn-sm btn-icon" title="Hapus admin"
                        delete-confirm="#form-delete-admin-{{ $admin->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                      <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="post"
                        id="form-delete-admin-{{ $admin->id }}">
                        @csrf
                        @method('delete')
                      </form>
                    @endcan
                  @endif
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
