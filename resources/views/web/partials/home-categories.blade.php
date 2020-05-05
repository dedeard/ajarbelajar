<home-category-scroll inline-template>
<div class="home-categories">
  <div class="panel">
    <div class="panel-body">
      <h2>Mau belajar apa hari ini?</h2>
    </div>
    <hr class="my-0" v-show="open">
      <div class="panel-body scroll" v-show="open">
        <div class="scroll-wrapper" ref="elScroll">
          <div class="list-group scroll-content">
            @foreach(\App\Model\Category::has('posts')->orderBy('name', 'asc')->get() as $category)
              <a href="{{ route('category.show', $category->slug) }}" class="list-group-item">{{ $category->name }}</a>
            @endforeach
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="panel-body">
        <button @click="open = !open" class="btn btn-default btn-block">@{{ open ? 'Tutup' : 'Telusuri' }}</button>
      </div>
    </div>
  </div>
</home-category-scroll>