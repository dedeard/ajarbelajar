@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">MINITUTORS</h3>
        <div class="panel-actions">
        <a href="{{ route('minitutors.requests') }}" class="btn btn-sm btn-danger">Requested</a>
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <form method="get" class="input-group">
          <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request()->input('search') }}">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary"><i class="icon wb-search" aria-hidden="true"></i></button>
            </span>
          </form>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>{{__('Avatar')}}</th>
              <th>{{__('Name')}}</th>
              <th>{{__('Username')}}</th>
              <th>{{__('Email')}}</th>
              <th>{{__('Status')}}</th>
              <th>{{__('Dibuat pada')}}</th>
              <th class="text-center" style="width: 120px;">{{__('Actions')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($minitutors as $minitutor)
            <tr>
              <td class="align-middle">
                <span class="avatar">
                  <img src="{{ $minitutor->user->avatarUrl() }}" />
                </span>
              </td>
              <td class="align-middle"><a href="{{ route('minitutors.show', $minitutor->id) }}">{{ $minitutor->user->name }}</a></td>
              <td class="align-middle">{{ $minitutor->user->username }}</td>
              <td class="align-middle">{{ $minitutor->user->email }}</td>
              <td class="align-middle">{{ $minitutor->active ? 'Aktif' : 'Tidak Aktif' }}</td>
              <td class="align-middle">{{ $minitutor->created_at->format('d-M-Y') }}</td>
              <td class="text-center p-0 align-middle">
                <a href="{{ route('minitutors.show', $minitutor->id) }}" class="btn btn-outline-default btn-sm btn-icon"><i class="wb-eye"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="panel-footer">
        {{ $minitutors->links() }}
      </div>
    </div>
  </div>
@endsection
