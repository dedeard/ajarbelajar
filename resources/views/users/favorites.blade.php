@extends('layouts.app')

@section('content')
  <x-user-wrapper :user="$user">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Judul</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($user->favorites as $favorite)
          <tr>
            <td class="font-weight-bold align-middle">{{ $favorite->post->type }}</td>
            <td class="align-middle">{{ $favorite->post->title }}</td>
            <td class="align-middle">{{ $favorite->created_at->diffForhumans() }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-user-wrapper>
@endsection
