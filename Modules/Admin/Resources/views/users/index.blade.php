@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">ROLES</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">Create</a>
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <div class="input-group">
            <input type="text" class="form-control" name="" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
            </span>
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
                <th>{{__('Email Verified')}}</th>
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
                <td class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name() }}</a></td>
                <td  class="align-middle">{{ $user->username }}</td>
                <td  class="align-middle">{{ $user->email }}</td>
                <td  class="align-middle">{{ $user->email_verified_at ? $user->email_verified_at->format('d-m-Y') : '-' }}</td>
                <td class="text-center p-0 align-middle">
                  <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-default btn-sm btn-icon"><i class="wb-eye"></i></a>
                  <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-default btn-sm btn-icon"><i class="wb-pencil"></i></a>
                  <button class="btn btn-danger btn-sm btn-icon" v-delete-confirm:form-delete-user-{{ $user->id }}>
                    <i class="wb-trash"></i>
                  </button>
                  <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" id="form-delete-user-{{ $user->id }}">
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
      <div class="panel-footer">
        {{ $users->links() }}
      </div>
    </div>
  </div>
@endsection
