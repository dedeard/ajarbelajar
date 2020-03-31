<div class="container-fluid">
  @if ($message = Session::get('success'))
  <div class="mt-15 mb-0 alert alert-success alert-alt dark alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    {{ $message }}
  </div>
  @endif
  @if ($message = Session::get('error'))
  <div class="mt-15 mb-0 alert alert-danger alert-alt dark alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    {{ $message }}
  </div>
  @endif
  @if ($message = Session::get('warning'))
  <div class="mt-15 mb-0 alert alert-warning alert-alt dark alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    {{ $message }}
  </div>
  @endif
  @if ($message = Session::get('info'))
  <div class="mt-15 mb-0 alert alert-info alert-alt dark alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    {{ $message }}
  </div>
  @endif
</div>