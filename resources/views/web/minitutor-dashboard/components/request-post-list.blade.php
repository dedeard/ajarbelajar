<div class="request-post-list @if($post->requested_at) requested @endif">
  <div class="request-post-list-top">
    <div class="request-post-list-left">
      <div class="request-post-list-thumb">
        <img src="{{ $post->thumbUrl() }}" alt="{{ $post->title }}">
        @if($post->requested_at)
        <span class="post-status">
          Menunggu Persetujuan Admin
        </span>
        @endif
      </div>
    </div>
    <div class="request-post-list-right">
      <span class="info-time">diedit {{ $post->updated_at->diffForHumans() }}</span>
      <h3 class="info-title">{{ $post->title }}</h3>
      @if($post->category)
      <span class="category-info">{{ $post->category->name }}</span>
      @endif
      <div class="more-info">
        <span>Dibuat pada {{ $post->created_at->format('d M Y') }}</span>
      </div>
    </div>
  </div>
  <div class="request-post-list-bottom">
    <div class="row">
      <div class="col-4 px-1"><a href="{{ route('dashboard.minitutor.'.$post->type.'s.edit', $post->id) }}" class="btn btn-sm btn-primary btn-block">Edit</a></div>
      <div class="col-4 px-1">
        @if($post->requested_at)
        <a href="{{ route('dashboard.minitutor.'.$post->type.'s.publish.toggle', $post->id) }}" class="btn btn-sm btn-warning btn-block">Batalkan Publish</a>
        @else
        <a href="{{ route('dashboard.minitutor.'.$post->type.'s.publish.toggle', $post->id) }}" class="btn btn-sm btn-success btn-block">Publikasikan</a>
        @endif
      </div>
      <div class="col-4 pl-1"><a href="{{ route('dashboard.minitutor.'.$post->type.'s.destroy', $post->id) }}" class="btn btn-sm btn-danger btn-block" v-delete-confirm:form-delete-post-{{$post->id}}>Hapus</a></div>
    </div>
  </div>
</div>

<form action="{{ route('dashboard.minitutor.'.$post->type.'s.destroy', $post->id) }}" id="form-delete-post-{{$post->id}}" method="post">
@csrf
@method('delete')
</form>