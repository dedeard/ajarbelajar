@extends('layouts.app')

@section('content')
@component('components.user_show', ['user' => $user])

<table class="table table-hover">
  <thead>
    <tr>
      <th>Avatar</th>
      <th>Nama</th>
      <th>Username</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    @foreach($followings as $item)
    <tr>
      <td class="align-middle">
        <span class="avatar">
          <img src="{{ $item->minitutor->user->avatar_url }}" />
        </span>
      </td>
      <td class="align-middle"><a href="{{ route('minitutors.show', $item->minitutor->id) }}">{{ $item->minitutor->user->name }}</a></td>
      <td  class="align-middle">{{ $item->minitutor->user->username }}</td>
      <td  class="align-middle">{{ $item->minitutor->user->email }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endcomponent
@endsection
