@extends('admin.layouts.app')
@section('title', 'Daftar Pengguna')
@section('content')

<div class="panel">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar member</h3>
  </div>
  <div class="panel-body">
    <div class="btn-group" id="table-category-toolbar" role="group">
      <a type="button" href="{{ route('admin.user.create') }}" class="btn btn-outline btn-default">
        <i class="icon wb-plus" aria-hidden="true"></i>
      </a>
    </div>
    <table id="table-category" data-height="500" data-mobile-responsive="true">
      <thead>
        <tr>
          <th data-field="id" data-sortable="true">ID</th>
          <th data-field="username" data-sortable="true">Nama pengguna</th>
          <th data-field="email" data-sortable="true">Alamat Email</th>
          <th data-field="role" data-sortable="true">Wewenang</th>
          <th data-field="email_verified_at" data-sortable="true">Di Verifikasi</th>
          <th data-field="created_at" data-sortable="true">Mendaftar</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

@endsection

@section('script')
<script>
  var data = @json($users);
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
      window.location.href = 'user/'+ row.id +'/edit'
    })
  });
</script>
@endsection