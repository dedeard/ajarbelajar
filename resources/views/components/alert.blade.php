@if ($message = Session::get('success'))
  <script>
    Swal.fire({
      title: 'Sukses',
      text: '{{ $message }}',
      icon: 'success'
    })
  </script>
@endif
@if ($message = Session::get('error'))
  <script>
    Swal.fire({
      title: 'Error',
      text: '{{ $message }}',
      icon: 'error'
    })
  </script>
@endif
@if ($message = Session::get('warning'))
  <script>
    Swal.fire({
      title: 'Warning',
      text: '{{ $message }}',
      icon: 'warning'
    })
  </script>
@endif
@if ($message = Session::get('info'))
  <script>
    Swal.fire({
      title: 'Info',
      text: '{{ $message }}',
      icon: 'info'
    })
  </script>
@endif
