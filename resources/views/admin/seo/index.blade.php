@extends('admin.layouts.app')
@section('title', 'Seo')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Seo</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <tr>
        <th>Id</th>
        <th>Halaman</th>
        <th class="text-center">Aksi</th>
      </tr>
      @foreach($seos as $seo)
        <tr>
          <td>{{ $seo->id }}</td>
          <td>{{ $seo->name }}</td>
          <td class="text-center"><a href="{{ route('admin.seo.edit', $seo->id) }}">Edit</a></td>
        </tr>
      @endforeach
    </table>
  </div>
</div>

@endsection
