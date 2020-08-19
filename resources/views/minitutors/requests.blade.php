@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">MINITUTORS</h3>
        <div class="panel-actions">
          <a href="{{ route('minitutors.index') }}" class="btn btn-sm btn-primary">Back</a>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>{{__('Avatar')}}</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Username')}}</th>
              <th>{{__('Email')}}</th>
              <th class="text-center" style="width: 120px;">{{__('Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td class="align-middle">
                <span class="avatar">
                  <img src="{{ $user->avatarUrl() }}" />
                </span>
              </td>
              <td class="align-middle"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
              <td class="align-middle">{{ $user->username }}</td>
              <td class="align-middle">{{ $user->email }}</td>
              <td class="text-center p-0 align-middle">
                <a href="{{ route('minitutors.request.show', $user->id) }}" class="btn btn-outline-default btn-sm btn-icon"><i class="wb-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="panel-footer">
        {{ $users->links() }}
      </div>
    </div>
  </div>
@endsection
