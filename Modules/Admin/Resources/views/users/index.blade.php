<x-admin::layouts.main title="Daftar pengguna">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Daftar Pengguna</h3>
        <div class="my-auto ml-auto">
          @can('create user')
            <a href="{{ route('admin.users.create') }}"
              class="btn btn-sm btn-primary">Buat Pengguna Baru</a>
          @endcan
        </div>
      </div>
      <div class="card-body pb-0">
        <div class="form-group">
          <form method="get" class="input-group">
            <input type="text" class="form-control" name="search"
              placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-append">
              <button type="submit" class="btn btn-primary"><i
                  class="fas fa-search"></i></button>
            </span>
          </form>
        </div>
      </div>
      <div class="card-body table-responsive border-top text-nowrap p-0">
        <table class="table">
          <thead>
            <tr>
              <th>Avatar</th>
              <th>Nama</th>
              <th>Username</th>
              <th>Email</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="py-0 align-middle"><img src="{{ $user->avatar_url }}"
                    width="36px" alt="Avatar" class="avatar img-circle">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td class="py-0 text-center align-middle">
                  <div class="btn-group">
                    @can('update user')
                      <a href="{{ route('admin.users.edit', $user->id) }}"
                        class="btn btn-default btn-sm" title="Edit pengguna">
                        <i class="fas fa-edit"></i>
                      </a>
                    @endcan
                    @can('delete user')
                      <form action="{{ route('admin.users.destroy', $user->id) }}"
                        method="post" id="form-delete-user-{{ $user->id }}">
                        @csrf
                        @method('delete')
                      </form>
                      <button class="btn btn-danger btn-sm btn-icon"
                        title="Hapus pengguna"
                        delete-confirm="#form-delete-user-{{ $user->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    @endcan
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $users->links() }}
      </div>
    </div>
  </div>
</x-admin::layouts.main>
