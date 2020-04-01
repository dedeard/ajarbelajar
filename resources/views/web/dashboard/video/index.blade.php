@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel panel-bordered bg-light">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Dafatar Video yang sedang kamu kelola.</h3>
    <div class="panel-actions">
      <div class="btn-group">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-create-video">
          Buat baru
        </button>
      </div>
    </div>
  </div>
  <div class="panel-body">
    @if($videos->total())
    <div class="row">
      @foreach($videos as $video)
      <div class="col-lg-4">
        <div class="panel panel-primary panel-line shadow">
          <div class="panel-heading">
            <h3 class="panel-title text-capitalize text-truncate">{{ $video->title }}</h3>
          </div>
          <div class="panel-body">
            <p>Di Edit {{ $video->updated_at->diffForHumans() }}</p>
            <div class="btn-group">
              <a href="{{ route('dashboard.requested.create', $video->id) }}"
                class="btn btn-sm btn-icon btn-outline btn-default" data-toggle="tooltip" title="Publikasikan">
                <i class="icon wb-globe"></i>
              </a>
              <a href="{{ route('dashboard.video.edit', $video->id) }}"
                class="btn btn-sm btn-icon btn-outline btn-default" data-toggle="tooltip" title="Edit">
                <i class="icon wb-edit"></i>
              </a>
              <a href="#" class="btn btn-sm btn-icon btn-outline btn-default" delete-confirm
                data-target="#form-delete-video-{{$video->id}}" data-toggle="tooltip" title="Hapus">
                <i class="icon wb-trash"></i>
              </a>
            </div>
            <form id="form-delete-video-{{$video->id}}"
              action="{{ route('dashboard.video.destroy', $video->id) }}" method="post">
              @csrf
              @method('delete')
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Video.</h3>
      <a data-toggle="modal" data-target="#modal-create-video" href="#" class="btn btn-primary px-50">Buat
        Sekarang</a>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $videos->links() }}
  </div>
</div>
@endcomponent
<div class="modal fade" id="modal-create-video" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Buat vidio baru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('dashboard.video.store') }}">
          @csrf
          <div class="form-group">
            <label class="mb-3">Judul <span class="text-danger">*</span></label>
            <input name="title" class="form-control @error('title') is-invalid @enderror" type="text"
              value="{{ old('title') }}" />
            @error('title')
            <div class="invalid-feedback">
              <strong>{{ $message }}</strong>
            </div>
            @enderror
          </div>
          <div class="form-group mt-30">
            <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
              <span class="ladda-label">Simpan</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@if($errors->any())
@section('script')
<script>
$('#modal-create-video').modal('show')
</script>
@endsection
@endif