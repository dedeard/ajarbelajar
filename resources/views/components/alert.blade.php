@if ($message = Session::get('success'))
  <script>
    window.flash = ['success', '{{ $message }}']
  </script>
@endif
@if ($message = Session::get('error'))
  <script>
    window.flash = ['error', '{{ $message }}']
  </script>
@endif

@if (session()->has('success'))
  <script>
    window.flash = ['success', '{{ session('success') }}']
  </script>
@endif
@if (session()->has('error'))
  <script>
    window.flash = ['error', '{{ session('error') }}']
  </script>
@endif


<script>
  if (window.flash) {
    if (window.fire) {
      window.fire[window.flash[0]](window.flash[1])
      window.flash = undefined
    } else {
      document.addEventListener("DOMContentLoaded", function() {
        window.fire[window.flash[0]](window.flash[1])
        window.flash = undefined
      });
    }
  }
</script>
