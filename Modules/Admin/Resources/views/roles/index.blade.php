@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">ROLES</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">Create</a>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>{{__('Name')}}</th>
              <th class="text-center" style="width: 120px;">{{__('Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($roles as $role)
            <tr>
              <td class="font-weight-bold align-middle">{{ $role->name }}</td>
              <td class="text-center py-0 align-middle">
                @if($role->name !== 'Super Admin')
                  <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                    <i class="wb-pencil"></i>
                  </a>
                  <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-role-{{ $role->id }}>
                    <i class="wb-trash"></i>
                  </button>
                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post" id="form-delete-role-{{ $role->id }}">
                  @csrf
                  @method('delete')
                </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
