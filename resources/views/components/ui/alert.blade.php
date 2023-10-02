@if ($message = Session::get('success'))
  <script>
    window.flash = ['success', '{{ $message }}']
  </script>
@endif
@if ($message = Session::get('info'))
  <script>
    window.flash = ['info', '{{ $message }}']
  </script>
@endif
@if ($message = Session::get('error'))
  <script>
    window.flash = ['error', '{{ $message }}']
  </script>
@endif

<script>
  if (window.flash) {
    if (window.toast) {
      window.toast[window.flash[0]](window.flash[1])
      window.flash = undefined
    } else {
      document.addEventListener("DOMContentLoaded", function() {
        if (window.flash) {
          window.toast[window.flash[0]](window.flash[1])
          window.flash = undefined
        }
      });
    }
  }
</script>
