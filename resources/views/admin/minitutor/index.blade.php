@extends('admin.layouts.app')

@section('title', 'Daftar Minitutor')

@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Daftar MiniTutor</h3>
  </div>
  <div class="panel-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Nama pengguna</th>
          <th>Alamat Email</th>
          <th>Status</th>
          <th>Di Buat</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($minitutors as $minitutor)
        <tr>
          <td>{{ $minitutor->id }}</td>
          <td>{{ $minitutor->user->name() }}</td>
          <td>{{ $minitutor->user->username }}</td>
          <td>{{ $minitutor->user->email }}</td>
          <td>{{ $minitutor->active ? 'Aktiv' : 'Tidak Aktiv' }}</td>
          <td>{{ $minitutor->created_at->format('Y/m/d') }}</td>
          <td class="text-center">
            <a href="{{ route('admin.minitutor.show', $minitutor->id) }}">Lihat</a>
            
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $minitutors->links() }}
  </div>
</div>


@foreach($minitutors as $minitutor)
@if(!$minitutor->user->hasRole('Super Admin'))
<div class="modal fade" id="modal-minitutor-{{ $minitutor->id }}" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if($minitutor->active)
        <a class="btn btn-block btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor->id) }}">Non aktivkan {{ $minitutor['name'] }} sebegai MiniTutor</a>
        @else
        <a class="btn btn-block btn-warning" href="{{ route('admin.minitutor.active.toggle', $minitutor->id) }}">Aktivkan kembali {{ $minitutor['name'] }} sebegai MiniTutor</a>
        @endif
        <a class="btn btn-block btn-danger" delete-confirm data-target="#form-delete-minitutor-{{$minitutor->id}}" href="#">Hapus Permanen {{ $minitutor['name'] }} sebegai MiniTutor</a>

        <form action="{{ route('admin.minitutor.destroy', $minitutor->id) }}" id="form-delete-minitutor-{{$minitutor->id}}" method="post" class="d-none">
          @csrf
          @method('delete')
        </form>
      </div>
    </div>
  </div>
</div>
@endif
@endforeach
@endsection