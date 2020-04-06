<div class="user-post-count">
  <h3 class="user-post-count-title">
    Beragam, dan akan terus bertumbuh!
  </h3>
  <p class="user-post-count-description">
    AjarBelajar diisi oleh konten dari MiniTutor dengan berbagai macam latar
    belakang. Ada banyak bidang ilmu dan topik bahasan yang bisa disimak,
    dan akan terus bertambah.
  </p>
  <div class="row">
    <div class="col-lg-4">
      <div class="card p-30 flex-row justify-content-between">
        <div class="white">
          <i class="icon icon-circle icon-2x wb-user-circle bg-red-600"></i>
        </div>
        <div class="counter counter-md counter text-right">
          <div class="counter-number-group">
            <span class="counter-number">{{ \App\Model\User::count() }}</span>
            <span class="counter-number-related text-capitalize">Pengguna</span>
          </div>
          <div class="counter-label text-capitalize font-size-16">Terdaftar</div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card p-30 flex-row justify-content-between">
        <div class="white">
          <i class="icon icon-circle icon-2x wb-users bg-indigo-600"></i>
        </div>
        <div class="counter counter-md counter text-right">
          <div class="counter-number-group">
            <span class="counter-number">{{ \App\Model\Minitutor::count() }}</span>
            <span class="counter-number-related text-capitalize">MiniTutor</span>
          </div>
          <div class="counter-label text-capitalize font-size-16">Berkontribusi</div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card p-30 flex-row justify-content-between">
        <div class="white">
          <i class="icon icon-circle icon-2x wb-clipboard bg-green-600"></i>
        </div>
        <div class="counter counter-md counter text-right">
          <div class="counter-number-group">
            <span class="counter-number">{{ \App\Model\Post::where('draf', 0)->count() }}</span>
            <span class="counter-number-related text-capitalize">Postingan</span>
          </div>
          <div class="counter-label text-capitalize font-size-16">Terbit</div>
        </div>
      </div>
    </div>

  </div>
</div>