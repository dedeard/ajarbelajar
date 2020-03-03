@extends('admin.layouts.app')

@section('title', 'Daftar Minitutor')

@section('content')
<div class="panel">
    <div class="panel-heading">
      <h3 class="panel-title">Daftar MiniTutor</h3>
    </div>
    <div class="panel-body">
      <table id="table-minitutor" data-height="500" data-mobile-responsive="true">
        <thead>
          <tr>
            <th data-field="id" data-sortable="true">ID</th>
            <th data-field="name" data-sortable="true">Nama</th>
            <th data-field="username" data-sortable="true">Nama pengguna</th>
            <th data-field="active" data-sortable="true">Status</th>
            <th data-field="created_at" data-sortable="true">Di Buat</th>
          </tr>
        </thead>
      </table>
  </div>
</div>


@foreach($minitutors as $minitutor)
<div class="modal fade" id="modal-minitutor-{{ $minitutor['id'] }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if($minitutor['active'] === 'Aktiv')
        <a class="btn btn-block btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor['id']) }}">Non aktivkan {{ $minitutor['name'] }} sebegai MiniTutor</a>
        @else
        <a class="btn btn-block btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor['id']) }}">Aktivkan kembali {{ $minitutor['name'] }} sebegai MiniTutor</a>
        @endif
        <a class="btn btn-block btn-danger" delete-confirm data-target="#form-delete-minitutor-{{$minitutor['id']}}" href="#">Hapus Permanen {{ $minitutor['name'] }} sebegai MiniTutor</a>
        
        <form action="{{ route('admin.minitutor.destroy', $minitutor['id']) }}"
            id="form-delete-minitutor-{{$minitutor['id']}}" method="post" class="d-none">
            @csrf
            @method('delete')
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection

@section('script')
<script>
  var data = @json($minitutors);
  $(document).ready(function() {
    $('#table-minitutor').bootstrapTable({
      data: data,
      search: true,
      showToggle: true,
      showColumns: true,
      iconSize: 'outline',
      toolbar: '#table-minitutor-toolbar',
      icons: {
        refresh: 'wb-refresh',
        toggle: 'wb-order',
        columns: 'wb-list-bulleted'
      }
    }).on('dbl-click-row.bs.table', function(e, row, $element) {
      $('#modal-minitutor-' + row.id).modal('show')
    })
  });
</script>
@endsection