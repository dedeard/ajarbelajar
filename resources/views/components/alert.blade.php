@if($message = Session::get('success'))
  <app-alert inline-template>
    <div class="container-fluid" v-if="open">
      <div class="alert alert-primary dark alert-dismissible">
        <button type="button" class="close" @click="close">
          <span aria-hidden="true">×</span>
        </button>
        {{ $message }}
      </div>
    </div>
  </app-alert>
@endif
@if($message = Session::get('error'))
  <app-alert inline-template>
    <div class="container-fluid" v-if="open">
      <div class="alert alert-danger dark alert-dismissible" role="alert">
        <button type="button" class="close" @click="close">
          <span aria-hidden="true">×</span>
        </button>
        {{ $message }}
      </div>
    </div>
  </app-alert>
@endif
@if($message = Session::get('warning'))
  <app-alert inline-template>
    <div class="container-fluid" v-if="open">
      <div class="alert alert-warning dark alert-dismissible" role="alert">
        <button type="button" class="close" @click="close">
          <span aria-hidden="true">×</span>
        </button>
        {{ $message }}
      </div>
    </div>
  </app-alert>
@endif
@if($message = Session::get('info'))
  <app-alert inline-template>
    <div class="container-fluid" v-if="open">
      <div class="alert alert-info dark alert-dismissible" role="alert">
        <button type="button" class="close" @click="close">
          <span aria-hidden="true">×</span>
        </button>
        {{ $message }}
      </div>
    </div>
  </app-alert>
@endif
