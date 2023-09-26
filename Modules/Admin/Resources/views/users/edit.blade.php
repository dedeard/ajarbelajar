<x-admin::layouts.main title="Edit Pengguna">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex">
        <h3 class="card-title my-auto">Edit Pengguna</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Kembali</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.users.update', $user->id) }}" method="post">
          @csrf
          @method('put')
          <x-admin::input name="name" label="Nama*" :value="$user->name" />
          <x-admin::input name="username" label="Username*" :value="$user->username" />
          <x-admin::input name="email" label="Email*" :value="$user->email" />
          <x-admin::input name="password" label="Password*" type="password" />
          <x-admin::input name="website" label="Website" :value="$user->website" />
          <x-admin::textarea name="bio" label="Bio">{{ $user->bio }}</x-admin::textarea>
          <x-admin::checkbox name="email_verified" label="Verifikasi Email" :checked="$user->hasVerifiedEmail()" />
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan
              Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-admin::layouts.main>
