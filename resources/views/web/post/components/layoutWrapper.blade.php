<div class="container py-15">
  <div class="row">
    <div class="col-lg-8">
      {{ $slot }}
    </div>
  
    <div class="col-lg-4">
      @component('web.components.minitutor_card')
        @slot('minitutor', $post->user->minitutor)
      @endcomponent
    </div>
  </div>
</div>
