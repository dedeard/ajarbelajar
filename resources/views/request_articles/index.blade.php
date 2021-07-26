@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3>Daftar Artikel Permintaan</h3>
      </div>
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
          @foreach ($articles as $article)
            <tr>
              <td class="align-middle">{{ $article->title }}</td>
              <td class="align-middle">{{ $article->minitutor->user->name }}</td>
              <td class="align-middle">{{ $article->category ? $article->category->name : '-' }}</td>
              <td class="align-middle">{{ $article->requested_at }}</td>
              <td class="align-middle">{{ $article->created_at }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('request-articles.show', $article->id) }}" class="btn btn-default btn-sm" title="lihat">
                  <i class="fas fa-eye"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-footer">
        {{ $articles->links() }}
      </div>
    </div>
  </div>
@endsection
