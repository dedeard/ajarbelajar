@extends('layouts.app')

@section('content')
  <x-minitutor-wrapper :minitutor="$minitutor">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>Avatar</th>
          <th>Nama</th>
          <th>Username</th>
          <th>Email</th>
          <th class="text-center" style="width: 140px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($followers as $follower)
          <tr>
            <td class="align-middle">
              <span class="avatar">
                <img src="{{ $follower->user->avatar_url }}" />
              </span>
            </td>
            <td class="align-middle"><a href="{{ route('users.show', $follower->user->id) }}">{{ $follower->user->name }}</a></td>
            <td class="align-middle">{{ $follower->user->username }}</td>
            <td class="align-middle">{{ $follower->user->email }}</td>
            <td class="text-center py-0 align-middle">
              <a href="{{ route('users.show', $follower->user->id) }}" class="btn btn-default btn-sm"><i class="fas fa-eye"></i></a>
              <a href="{{ route('users.edit', $follower->user->id) }}" class="btn btn-default btn-sm"><i class="fas fa-edit"></i></a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </x-minitutor-wrapper>
@endsection
