@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Search Engine Optimize</h3>
        <div class="panel-actions">
          <a href="{{ route('seos.create') }}" class="btn btn-sm btn-primary">Buat SEO</a>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Path</th>
              <th>Title</th>
              <th class="text-center" style="width: 120px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($seos as $seo)
            <tr>
              <td class="align-middle">{{ $seo->path }}</td>
              <td class="align-middle">{{ $seo->title }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('seos.edit', $seo->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                  <i class="wb-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-seo-{{ $seo->id }}>
                  <i class="wb-trash"></i>
                </button>
                <form action="{{ route('seos.destroy', $seo->id) }}" method="post" id="form-delete-seo-{{ $seo->id }}">
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
