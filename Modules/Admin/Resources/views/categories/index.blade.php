<x-admin::layouts.main title="Daftar Kategori">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Daftar Kategori</h3>
        <div class="my-auto ml-auto">
          @can('create category')
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Buat Kategori Baru</a>
          @endcan
        </div>
      </div>
      <div class="card-body pb-0">
        <div class="form-group">
          <form method="get" class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-append">
              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
            </span>
          </form>
        </div>
      </div>
      <div class="card-body table-responsive border-top p-0">
        <table class="table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Slug</th>
              <th class="text-right">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $category)
              <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td class="py-0 text-right align-middle">
                  <div class="btn-group">
                    @can('update category')
                      <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-default btn-sm" title="Edit kategori">
                        <i class="fas fa-edit"></i>
                      </a>
                    @endcan
                    @can('delete category')
                      <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post"
                        id="form-delete-category-{{ $category->id }}">
                        @csrf
                        @method('delete')
                      </form>
                      <button class="btn btn-danger btn-sm btn-icon" title="Hapus kategori"
                        delete-confirm="#form-delete-category-{{ $category->id }}">
                        <i class="fas fa-trash"></i>
                      </button>
                    @endcan
                  </div>
                </td>
              </tr>

              <tr class="expandable-body d-none">
                <td colspan="3">
                  <p>
                    {{ $category->description }}
                  </p>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $categories->links() }}
      </div>
    </div>
  </div>
</x-admin::layouts.main>
