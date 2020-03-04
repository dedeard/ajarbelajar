@extends('admin.layouts.app')
@section('title', 'Buat Video')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Buat Video untuk minitutor</h3>
  </div>
  <div class="panel-body">
  <table id="table-video" data-height="500" data-mobile-responsive="true">
      <thead>
        <tr>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="name" data-sortable="true">Nama</th>
          <th data-field="username" data-sortable="true">Nama pengguna</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection


@section('script')
<script>
  var data = @json($minitutors);
  $(document).ready(function() {
    $('#table-video').bootstrapTable({
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
      window.location.href = '/admin/video/create/'+ row.user_id
    })
  });
</script>
@endsection