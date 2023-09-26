<a x-data="{
    logout() {
        window.Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Anda akan keluar secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'p-3 w-[100px] ml-3 border text-white hover:disabled:cursor-wait inline-block cursor-pointer select-none items-center justify-center rounded text-center text-sm font-medium leading-none disabled:opacity-70 bg-red-600 hover:bg-red-700 hover:disabled:bg-red-600 border-red-600 hover:border-red-700 hover:disabled:border-red-600 disabled:text-transparent',
                cancelButton: 'p-3 w-[100px] border text-white hover:disabled:cursor-wait inline-block cursor-pointer select-none items-center justify-center rounded text-center text-sm font-medium leading-none disabled:opacity-70 bg-primary-600 hover:bg-primary-700 hover:disabled:bg-primary-600 border-primary-600 hover:border-primary-700 hover:disabled:border-primary-600 disabled:text-transparent',
            },
        }).then((result) => {
            if (result.value) {
                this.$refs.logoutForm.submit()
            }
        })
    }
}" x-on:click.prevent="logout" href="{{ route('logout') }}" {{ $attributes }}>
  {{ $slot }}
  <form x-ref="logoutForm" class="hidden" action="{{ route('logout') }}" method="post">
    @csrf
  </form>
</a>
