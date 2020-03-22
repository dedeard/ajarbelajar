@extends('admin.layouts.app')
@section('title', 'Buat Video')
@section('content')

<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Buat Video untuk minitutor</h3>
  </div>
  <div class="panel-body">
    <div class="row mb-15">
      <div class="col-lg-4 ml-auto">
        <form method="get" class="row">
          <div class="col-9 pr-0">
            <input type="text" name="search" placeholder="Cari minitutor..." class="form-control" value="{{request()->input('search')}}">
          </div>
          <div class="col-3">
            <button class="btn btn-primary btn-block">Cari</button>
          </div>
        </form>
      </div>
    </div>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nama</th>
          <th>Nama pengguna</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($minitutors as $minitutor)
          <tr>
            <td>{{ $minitutor->id }}</td>
            <td>{{ $minitutor->user->name() }}</td>
            <td>{{ $minitutor->user->username }}</td>
            <td class="text-center">
              <a href="{{ route('admin.videos.create.create', $minitutor->id) }}">Buat</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection