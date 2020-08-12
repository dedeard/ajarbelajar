@extends('admin::layouts.master')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">PERMISSiONS</h3>
        <div class="panel-actions">
          <a href="{{ route('admin.permissions.create') }}" class="btn btn-sm btn-primary">Create</a>
        </div>
      </div>
      <div class="table-responsive pt-2">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>{{__('Name')}}</th>
              <th class="text-center" style="width: 120px;">{{__('Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($permissions as $permission)
            <tr>
              <td class="font-weight-bold align-middle">{{ $permission->name }}</td>
              <td class="text-center py-0 align-middle">
                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-outline-default btn-sm btn-icon" title="Edit">
                  <i class="wb-pencil"></i>
                </a>
                <button class="btn btn-danger btn-sm btn-icon" title="Delete" v-delete-confirm:form-delete-permission-{{ $permission->id }}>
                  <i class="wb-trash"></i>
                </button>
                <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post" id="form-delete-permission-{{ $permission->id }}">
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
  </div>
@endsection
