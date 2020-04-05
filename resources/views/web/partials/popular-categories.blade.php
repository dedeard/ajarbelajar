<?php
$categories = \App\Model\Category::has('posts')->withCount([
  'posts as post_count' => function($q){
      return $q->where('draf', false);
  }
])->orderBy('post_count', 'desc')->limit(4)->get();
?>

<div class="popular-categories">
  <h3 class="popular-categories-title">Kategori populer</h3>
  <div class="row">
    @foreach($categories as $category)
    <div class="col-lg-3">
      <a class="popular-categories-card" href="{{ route('category.show', $category->slug) }}">
        <h4 class="info-title text-truncate">{{ $category->name }}</h4>
      </a>
    </div>
    @endforeach
  </div>
</div>