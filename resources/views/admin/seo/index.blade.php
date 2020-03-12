@extends('admin.layouts.app')
@section('title', 'Seo')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Seo</h3>
  </div>
  <div class="panel-body">
    <table class="table">
      <tr>
        <th>Halaman</th>
        <th>Aksi</th>
      </tr>
      @foreach($pages as $slug => $name)
        <tr>
          <td>{{ $name }}</td>
          <td><a href="{{ route('admin.seo.edit', $slug) }}">Edit</a></td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
