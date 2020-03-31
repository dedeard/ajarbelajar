@extends('admin.layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Kategori</h3>
  </div>
  <div class="panel-body">
    <div class="row mb-15">
      <div class="col-lg-8">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Buat Kategori</a>
      </div>
    </div>
    <table class="table table-bordered" id="categories-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Slug</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->slug }}</td>
          <td class="text-center">
            <a href="{{ route('admin.categories.edit', $user->id) }}">Edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $categories->links() }}
  </div>
</div>

@endsection