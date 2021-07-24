@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Permission</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-primary">Buat Permission</a>
        </div>
      </div>
      <table class="table table-hover m-0">
        <thead>
          <tr>
            <th>Nama</th>
            <th class="text-center" style="width: 120px;">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($permissions as $permission)
            <tr>
              <td class="align-middle">{{ $permission->name }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-default btn-sm" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" delete-confirm="#form-delete-permission-{{ $permission->id }}">
                  <i class="fas fa-trash"></i>
                </button>
                <form action="{{ route('permissions.destroy', $permission->id) }}" method="post" id="form-delete-permission-{{ $permission->id }}">
                  @csrf
                  @method('delete')
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
