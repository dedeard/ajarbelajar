@extends('layouts.app')

@section('content')
  @component('components.minitutor_show', ['minitutor' => $minitutor])
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Status</th>
          <th>Dibuat pada</th>
          <th class="text-center" style="width: 120px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($playlists as $playlist)
          <tr>
            <td class="font-weight-bold align-middle">{{ $playlist->title }}</td>
            <td class="font-weight-bold align-middle">{{ $playlist->category ? $playlist->category->name : '-' }}</td>
            <td class="font-weight-bold align-middle">{{ $playlist->draf ? 'Draf' : 'Publik' }}</td>
            <td class="font-weight-bold align-middle">{{ $playlist->created_at }}</td>
            <td class="text-center py-0 align-middle">
              <a href="{{ route('playlists.edit', $playlist->id) }}" class="btn btn-default btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-playlist-{{ $playlist->id }}>
                <i class="fas fa-trash"></i>
              </button>
              <form action="{{ route('playlists.destroy', $playlist->id) }}" method="post" id="form-delete-playlist-{{ $playlist->id }}">
                @csrf
                @method('delete')
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endcomponent
@endsection
