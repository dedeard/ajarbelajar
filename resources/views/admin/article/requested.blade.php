@extends('admin.layouts.app')
@section('title', 'Daftar Permintaan Artikel')
@section('content')
<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar Permintaan Artikel</h3>
  </div>
  <div class="panel-body">
    <table id="table-requested-article" data-height="500" data-mobile-responsive="true">
      <thead>
        <tr>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="username" data-sortable="true">Username</th>
          <th data-field="title" data-sortable="true">Slug</th>
          <th data-field="requested_at" data-sortable="true">Dibuat</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@section('script')
<script>
  var data = @json($articles);
  $(document).ready(function() {
    $('#table-requested-article').bootstrapTable({
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
      window.location.href = 'requested/'+ row.id
    })
  });
</script>
@endsection