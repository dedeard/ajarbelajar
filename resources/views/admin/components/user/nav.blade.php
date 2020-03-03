<div class="row">
  <div class="col-lg-3">
    <div class="kt-portlet">
      <div class="kt-portlet__body">
        <div class="kt-widget kt-widget--user-profile-4">
          <div class="kt-widget__head">
            <div class="kt-widget__media">
              <form action="{{route('admin.user.update.avatar', $user->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                  <div class="kt-avatar kt-avatar--outline kt-avatar--circle">
                  @if ($user->avatar)
                  <img alt="photo" class="kt-avatar__holder" src="{{ asset('storage/avatar/' . $user->avatar) }}">
                  @else
                  <img alt="photo" class="kt-radius-100" src="{{ asset('assets/img/avatar.jpg') }}" />
                  @endif
                  <label class="kt-avatar__upload" data-toggle="kt-tooltip" title="Ganti avatar">
                    <i class="fa fa-pen"></i>
                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" id="input_avatar">
                  </label>
                </div>
              </form>
            </div>
            @error('avatar')
              <span class="text-center d-block mt-2 font-weight-bold text-danger">{{ $message }}</span>
            @enderror
            <div class="kt-widget__content">
              <div class="kt-widget__section text-center py-3">
                <span class="lead font-weight-bold text-uppercase">{{$user->first_name .' '. $user->last_name}}</span>
                <div class="kt-widget__button">
                  <span class="btn btn-label-primary btn-sm">{{$user->username}}</span>
                </div>
                <div class="pt-3">
                  @if($user->instagram)
                  <a href="https://instagram.com/{{ $user->instagram }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-instagram">
                    <i class="socicon-instagram"></i>
                  </a>
                  @endif
                  @if($user->facebook)
                  <a href="https://facebook.com/{{ $user->facebook }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-facebook">
                    <i class="socicon-facebook"></i>
                  </a>
                  @endif
                  @if($user->youtube)
                  <a href="https://youtube.com/channel/{{ $user->youtube }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-youtube">
                    <i class="socicon-youtube"></i>
                  </a>
                  @endif
                  @if($user->twitter)
                  <a href="https://twitter.com/{{ $user->twitter }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-twitter">
                    <i class="socicon-twitter"></i>
                  </a>
                  @endif
                  @if($user->github)
                  <a href="https://github.com/{{ $user->github }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-dark">
                    <i class="socicon-github"></i>
                  </a>
                  @endif
                  @if($user->website)
                  <a href="https://website.com/{{ $user->website }}" target="_blank" class="btn btn-icon btn-circle m-2 btn-label-primary">
                    <i class="flaticon2-world"></i>
                  </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-9">
    <div class="kt-portlet kt-portlet--last kt-portlet--head-lg kt-portlet--responsive-mobile kt-portlet--tabs">
      <div class="kt-portlet__head">
        <div class="kt-portlet__head-toolbar mr-auto">
          <ul class="nav nav-tabs nav-tabs-line nav-tabs-bold nav-tabs-line-3x">
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.user.show.activity', $user->id) ? 'active' : '' }}" href="{{ route('admin.user.show.activity', $user->id) }}">
                Aktivitas
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.user.edit.account', $user->id) ? 'active' : '' }}" href="{{ route('admin.user.edit.account', $user->id) }}">
                Edit Akun
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Route::is('admin.user.edit.profile', $user->id) ? 'active' : '' }}" href="{{ route('admin.user.edit.profile', $user->id) }}">
                Edit Profile
              </a>
            </li>
          </ul>
        </div>
        <div class="kt-portlet__head-toolbar">
          <div class="btn-group my-auto" role="group" aria-label="Button group with nested dropdown">
            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary btn-icon" data-toggle="dropdown">
                <i class="flaticon2-console"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-right  dropdown-menu-md">
                <ul class="kt-nav">
                  <li class="kt-nav__item">
                    <a href="{{ route('admin.user.verifyEmailToggle', $user->id) }}" class="kt-nav__link">
                      <span class="kt-nav__link-text">
                        @if($user->email_verified_at)
                          Hapus Verifikasi email
                        @else
                          Verifikasi alamat email
                        @endif
                      </span>
                    </a>
                  </li>
                  <li class="kt-nav__item">
                    <a href="{{route('admin.user.minitutor', $user->id)}}" class="kt-nav__link">
                      <span class="kt-nav__link-text">
                      @if ($user->minitutorWithTrashed)
                        @if ($user->minitutorWithTrashed->trashed())
                          Aktivkan Minitutor
                        @else
                          Nonaktivkan Minitutor
                        @endif
                      @else
                        Jadikan Minitutor
                      @endif
                      </span>
                    </a>
                  </li>
                  <li class="kt-nav__separator"></li>
                  <li class="kt-nav__foot">
                    <a class="btn btn-label-danger btn-bold btn-sm" data-toggle="delete-confirm" data-target="{{$user->id}}" href="{{ route('admin.user.destroy', $user->id) }}">Hapus member</a>
                    <form action="{{ route('admin.user.destroy', $user->id) }}" id="form-delete-user-{{$user->id}}" method="post" class="d-none">
                      @csrf
                      @method('delete')
                    </form>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="kt-portlet__body">
        {{ $slot }}
      </div>
    </div>
  </div>
</div>