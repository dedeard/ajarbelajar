@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Kategori</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Buat Kategori</a>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Slug</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $category)
              <tr>
                <td class="align-middle">{{ $category->name }}</td>
                <td class="align-middle">{{ $category->slug }}</td>
                <td class="text-center p-0 align-middle">
                  <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-default btn-icon" title="Edit">
                    <i class="fas fa-edit"></i>
                  </a>
                  <button class="btn btn-sm btn-danger btn-icon" title="Delete" v-delete-confirm:form-delete-category-{{ $category->id }}>
                    <i class="fas fa-trash"></i>
                  </button>
                  <form action="{{ route('categories.destroy', $category->id) }}" method="post" id="form-delete-category-{{ $category->id }}">
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
  </div>
@endsection
