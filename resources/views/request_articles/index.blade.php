@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Daftar Artikel Permintaan</h3>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Judul</th>
              <th>Penulis</th>
              <th>Kategori</th>
              <th>Dikirim pada</th>
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
              <td class="font-weight-bold align-middle">{{ $article->requested_at }}</td>
              <td class="font-weight-bold align-middle">{{ $article->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('request-articles.show', $article->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="lihat">
                  <i class="wb-eye"></i>
                </a>
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
