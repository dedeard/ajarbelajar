@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Artikel</h3>
        <div class="panel-actions">
          <a href="{{ route('articles.minitutors') }}" class="btn btn-sm btn-primary">Buat Artikel</a>
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
              <th>Judul</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Status</th>
              <th>Dibuat pada</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($articles as $article)
            <tr>
              <td class="font-weight-bold align-middle">{{ $article->title }}</td>
              <td class="font-weight-bold align-middle">{{ $article->minitutor->user->name }}</td>
              <td class="font-weight-bold align-middle">{{ $article->category ? $article->category->name : '-' }}</td>
              <td class="font-weight-bold align-middle">{{ $article->draf ? 'Draf' : 'Publik' }}</td>
              <td class="font-weight-bold align-middle">{{ $article->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                  <i class="wb-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-article-{{ $article->id }}>
                  <i class="wb-trash"></i>
                </button>
                <form action="{{ route('articles.destroy', $article->id) }}" method="post" id="form-delete-article-{{ $article->id }}">
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
        {{ $articles->links() }}
      </div>
    </div>
  </div>
@endsection
