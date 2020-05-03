<div class="home-categories">
  <div class="panel panel-body">
    <h2>Mau Belajar apa hari ini?</h2>
    <form action="{{ route('category.index') }}" method="GET">
      <input type="text" name="search" id="" class="form-control bg-light" placeholder="Apa yang ingin anda pelajari">
      <div class="text-center">
        <button type="submit" class="btn btn-primary px-30 mt-15">Telusuri</button>
      </div>
    </form>
  </div>
</div>