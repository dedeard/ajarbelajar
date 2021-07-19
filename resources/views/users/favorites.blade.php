@extends('layouts.app')

@section('content')
  @component('components.user_show', ['user' => $user])
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th class="text-center" style="width: 120px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($favorites as $favorite)
          <tr>
            <td class="font-weight-bold align-middle">{{ $favorite->type }}</td>
            <td class="align-middle">{{ $favorite->title }}</td>
            <td class="align-middle">{{ $favorite->category ? $favorite->category->name : '-' }}</td>
            <td class="text-center py-0 align-middle">
              <a href="{{ route($favorite->getTable() . '.edit', $favorite->id) }}" class="btn btn-default btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endcomponent
@endsection
