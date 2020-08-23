@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Playlist</h3>
        <div class="panel-actions">
          <a href="{{ route('playlists.minitutors') }}" class="btn btn-sm btn-primary">Buat Playlist</a>
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <form method="get" class="input-group">
          <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
            </span>
          </form>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>{{__('Title')}}</th>
              <th>{{__('Author')}}</th>
              <th>{{__('Category')}}</th>
              <th>{{__('Status')}}</th>
              <th>{{__('Video Count')}}</th>
              <th>{{__('Created at')}}</th>
              <th class="text-center" style="width: 120px;">{{__('Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($playlists as $playlist)
            <tr>
              <td class="font-weight-bold align-middle">{{ $playlist->title }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->minitutor->user->name }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->category ? $playlist->category->name : '-' }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->draf ? 'Draf' : 'Publik' }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->videos()->count() }}</td>
              <td class="font-weight-bold align-middle">{{ $playlist->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('playlists.edit', $playlist->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                  <i class="wb-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-playlist-{{ $playlist->id }}>
                  <i class="wb-trash"></i>
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
      </div>
      <div class="panel-footer">
        {{ $playlists->links() }}
      </div>
    </div>
  </div>
@endsection
