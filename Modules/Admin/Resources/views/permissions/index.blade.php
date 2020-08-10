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
      <div class="panel-body py-2 px-0">
        <div class="table-responsive">
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
                <td class="text-center">
                  @if($permission->name !== 'Super Admin')
                    <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-sm btn-default" title="Edit">
                      <i class="wb-pencil"></i>
                    </a>
                    <button class="btn btn-sm btn-default text-danger" title="Delete" v-delete-confirm:form-delete-permission-{{ $permission->id }}>
                      <i class="wb-trash"></i>
                    </button>
                  <form action="{{ route('admin.permissions.destroy', $permission->id) }}" method="post" id="form-delete-permission-{{ $permission->id }}">
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
  </div>
@endsection
