@extends('admin::layouts.master')

@section('content')
<div class="container-fluid">
  <div class="panel panel-bordered">
    <div class="panel-heading">
      <h3 class="panel-title">Kategori</h3>
      <div class="panel-actions">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Create</a>
      </div>
    </div>
    <div class="panel-body">
      <div class="table-responsive">
        <table class="table table-hover m-0">
          <thead>
            <tr>
              <th>{{ __('Name') }}</th>
              <th>{{ __('Slug') }}</th>
              <th class="text-center" style="width: 120px;">{{ __('Actions') }}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categories as $category)
              <tr>
                <td class="align-middle">{{ $category->name }}</td>
                <td class="align-middle">{{ $category->slug }}</td>
                <td class="text-center p-0 align-middle">
                  <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-default" title="Edit">
                    <i class="wb-pencil"></i>
                  </a>
                  <button class="btn btn-sm btn-default text-danger" title="Delete" v-delete-confirm:form-delete-category-{{ $category->id }}>
                    <i class="wb-trash"></i>
                  </button>
                  <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" id="form-delete-category-{{ $category->id }}">
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
</div>
@endsection
