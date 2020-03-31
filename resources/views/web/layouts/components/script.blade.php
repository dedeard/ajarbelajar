<script src="{{ asset('js/app.js') }}"></script>
@if(env('APP_ENV') !== 'local')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-160467804-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());
  gtag('config', 'UA-160467804-1');
</script>
@endif