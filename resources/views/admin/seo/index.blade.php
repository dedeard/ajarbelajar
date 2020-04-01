@extends('admin.layouts.app')
@section('title', 'Seo')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Seo</h3>
    <div class="panel-actions">
      <a href="{{ route('admin.seo.create') }}" class="btn btn-primary">CREATE</a>
    </div>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tr>
        <th>Id</th>
        <th>Path</th>
        <th class="text-center">Aksi</th>
      </tr>
      @foreach($seos as $seo)
        <tr>
          <td>{{ $seo->id }}</td>
          <td>{{ $seo->path }}</td>
          <td class="text-center">
            <a href="{{ route('admin.seo.edit', $seo->id) }}">Edit</a> | 
            <a href="{{ route('admin.seo.destroy', $seo->id) }}" delete-confirm data-target="#form-delete-seo-{{$seo->id}}">Hapus</a>
            <form id="form-delete-seo-{{$seo->id}}" action="{{ route('admin.seo.destroy', $seo->id) }}" method="POST" class="d-none">
              @csrf
              @method('delete')
            </form>
          </td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
