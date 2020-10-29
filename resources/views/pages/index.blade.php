@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Halaman</h3>
        <div class="panel-actions">
          <a href="{{ route('pages.create') }}" class="btn btn-sm btn-primary">Buat Halaman</a>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Slug</th>
              <th>Title</th>
              <th>Status</th>
              <th>Dibuat pada</th>
              <th>Diedit pada</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pages as $page)
            <tr>
              <td class="align-middle">{{ $page->slug }}</td>
              <td class="align-middle">{{ $page->title }}</td>
              <td class="align-middle">{{ $page->draf ? 'Draf' : 'Aktif' }}</td>
              <td class="align-middle">{{ $page->created_at->format('y/m/d') }}</td>
              <td class="align-middle">{{ $page->updated_at->format('y/m/d') }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                  <i class="wb-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-page-{{ $page->id }}>
                  <i class="wb-trash"></i>
                </button>
                <form action="{{ route('pages.destroy', $page->id) }}" method="post" id="form-delete-page-{{ $page->id }}">
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
