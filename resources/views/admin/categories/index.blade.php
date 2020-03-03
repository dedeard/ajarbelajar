@extends('admin.layouts.app')

@section('title', 'Daftar Kategori')


@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar kategori</h3>
  </div>
  <div class="panel-body">
    <div class="btn-group" id="table-category-toolbar" role="group">
      <a type="button" href="{{ route('admin.categories.create') }}" class="btn btn-outline btn-default">
        <i class="icon wb-plus" aria-hidden="true"></i>
      </a>
    </div>
    <table id="table-category" data-height="500" data-mobile-responsive="true">
      <thead>
        <tr>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="name" data-sortable="true">Nama</th>
          <th data-field="slug" data-sortable="true">Slug</th>
          <th data-field="created_at" data-sortable="true">Dibuat</th>
          <th data-field="updated_at" data-sortable="true">Diedit</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('script')
<script>
  var data = @json($categories);
  $(document).ready(function() {
    $('#table-category').bootstrapTable({
      data: data,
      search: true,
      showToggle: true,
      showColumns: true,
      iconSize: 'outline',
      toolbar: '#table-category-toolbar',
      icons: {
        refresh: 'wb-refresh',
        toggle: 'wb-order',
        columns: 'wb-list-bulleted'
      }
    }).on('dbl-click-row.bs.table', function(e, row, $element) {
      window.location.href = 'categories/'+ row.id +'/edit'
    })
  });
</script>
@endsection