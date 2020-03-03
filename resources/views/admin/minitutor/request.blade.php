@extends('admin.layouts.app')

@section('title', 'Daftar permintaan Minitutor')


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
            <th data-field="updated_at" data-sortable="true">Di Update</th>
            <th data-field="created_at" data-sortable="true">Di Buat</th>
          </tr>
        </thead>
      </table>
  </div>
</div>


{{--
  <div class="kt-portlet m-0">
      <div class="kt-portlet__body">
          <form class="row" action="" method="GET">
              <div class="col-md-6">
                <h3>DAFTAR PERMINTAAN MINITUTOR</h3>
              </div>
              <div class="col-md-6">
                  <div class="d-flex">
                      <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Urutkan
                          </button>
                          <div class="dropdown-menu">
                              <a class="dropdown-item" href="?">Normal</a>
                              <a class="dropdown-item" href="?orderBy=created_at&order=desc">Terbaru</a>
                              <a class="dropdown-item" href="?orderBy=created_at&order=asc">Terlama</a>
                          </div>
                      </div>
                      <div class="input-group w-100">
                          <div class="kt-input-icon kt-input-icon--left">
                              <input type="text" name="search" class="form-control" placeholder="Search..."
                                  value="{{ request('search') }}">
                              <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                  <span><i class="la la-search"></i></span>
                              </span>
                          </div>
                      </div>
                      <button class="btn btn-primary" type="submit">Tampilkan</button>
                  </div>
              </div>
          </form>
      </div>
  </div>
  <div class="kt-portlet m-0">
      <div class="kt-portlet__body p-0">
          <table class="table m-0">
              <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Dibuat</th>
                    <th>Diupdate</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($requestLists as $x => $requestList)
                  <tr>
                      <td>
                        <a class="kt-link font-weight-bold" href="{{ route('admin.user.show', $requestList->user_id) }}">
                          {{ $requestList->user->profile->first_name }}
                          {{ $requestList->user->profile->last_name }}
                        </a>
                      </td>
                      <td>{{ $requestList->user->username }}</td>
                      <td>{{ $requestList->created_at->diffForHumans() }}</td>
                      <td>{{ $requestList->updated_at->diffForHumans() }}</td>
                      <td class="text-right p-0">
                        <button class="btn bg-light text-primary btn-icon" data-toggle="modal" data-target="#modal-request-minitutor-{{ $requestList->id }}">
                          <i class="fa fa-eye"></i>
                        </button>
                          <!-- Modal -->
                          <div class="modal fade text-left" id="modal-request-minitutor-{{ $requestList->id }}">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title">{{ $requestList->user->first_name }}</h5>
                                          <button type="button" class="close" data-dismiss="modal">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                        <h3 class="mb-3 mt-4">Data pengguna</h3>
                                        <div class="p-3 bg-light">

                                          <div class="row">
                                            <div class="col-lg-2 col-md-4 mb-3">
                                              <a href="#show-activity" class="kt-media kt-media--xl kt-media--circle">
                                                @if ($requestList->user->image)
                                                <img alt="photo" src="{{ asset('storage/avatar/' . $requestList->user->avatar) }}">
                                                @else
                                                <img alt="photo" src="{{ asset('img/avatar.png') }}" />
                                                @endif
                                              </a>
                                            </div>
                                            <div class="col-lg-10 col-md-6 mb-3">
                                              <h5>Nama</h5>
                                              <p class="mb-4"><a class="kt-link" href="#show-activity">{{ $requestList->user->profile->first_name }} {{ $requestList->user->profile->last_name }}</a></p>
                                              <h5>Username</h5>
                                              <p class="mb-4">{{ $requestList->user->username }}</p>
                                              <h5>Email</h5>
                                              <p class="mb-4">{{ $requestList->user->email }}</p>
                                              <h5>Email di verifikasi</h5>
                                              <p class="mb-4">{{ $requestList->user->email_verified_at ?? 'Tidak' }}</p>
                                            </div>
                                          </div>
                                        </div>
                                          
                                          <h3 class="mb-3 mt-4">Data Studi</h3>
                                          <h5>Pedidikan terakhir</h5>
                                        <p class="mb-4"><strong>{{ $requestList->last_education }}</strong></p>
                                        <h5>Universitas</h5>
                                        <p class="mb-4"><strong>{{ $requestList->university }}</strong></p>
                                        <h5>Kota dan negara tempat study</h5>
                                        <p class="mb-4"><strong>{{ $requestList->city_and_country_of_study }}</strong></p>
                                        <h5>Jurusan</h5>
                                        <p class="mb-4"><strong>{{ $requestList->majors }}</strong></p>

                                        <div class="bg-light p-3">

                                          <h5 class="mt-4">Spesialisasi/Minat bakat</h5>
                                          <p class="mb-4">{{ $requestList->interest_talent }}</p>
                                          <h5 class="mt-5">Kontak</h5>
                                          <p class="mb-4">{{ $requestList->contact }}</p>
                                          <h5 class="mt-5">Motivasi</h5>
                                          <p class="mb-4">{{ $requestList->reason }}</p>
                                          <h5 class="mt-5">Ekspektasi</h5>
                                          <p class="mb-4">{{ $requestList->expectation }}</p>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                          <button class="btn btn-success" onclick="$('#form-accept-request-{{$requestList->id}}').submit()">Terima</button>
                                          <button class="btn btn-danger" onclick="$('#form-reject-request-{{$requestList->id}}').submit()">Tolak</button>
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <form action="{{ route('admin.minitutor.request.reject', $requestList->id) }}"
                              id="form-reject-request-{{$requestList->id}}" method="post" class="d-none">
                              @csrf
                              @method('put')
                          </form>
                          <form action="{{ route('admin.minitutor.request.accept', $requestList->id) }}"
                              id="form-accept-request-{{$requestList->id}}" method="post" class="d-none">
                              @csrf
                              @method('put')
                          </form>
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>
--}}
@endsection

@section('script')
<script>
  var data = @json($requestLists);
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
    }).on('click-row.bs.table', function(e, row, $element) {
      window.location.href = 'request/'+ row.id
    })
  });
</script>
@endsection