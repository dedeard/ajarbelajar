@extends('layouts.app')

@section('content')
  @component('components.user_show', ['user' => $user])
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Tipe</th>
          <th>Judul</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($activities as $activity)
          <tr>
            <td class="font-weight-bold">{{ $activity['post']->getTable() }}</td>
            <td>{{ $activity['post']->title }}</td>
            <td>{{ $activity['updated_at']->diffForhumans() }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endcomponent
@endsection
