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
        @foreach ($user->activities as $activity)
          <tr>
            <td class="font-weight-bold">{{ $activity->post->type }}</td>
            <td>{{ $activity->post->title }}</td>
            <td>{{ $activity->updated_at->diffForhumans() }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-user-wrapper>
@endsection
