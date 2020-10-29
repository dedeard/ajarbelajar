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
    @foreach($articles as $article)
    <tr>
      <td class="font-weight-bold align-middle">{{ $article->title }}</td>
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
@endcomponent
@endsection
