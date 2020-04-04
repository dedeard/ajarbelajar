@extends('web.layouts.app')
@section('content')
@component('web.dashboard.components.layoutWrapper')

<div class="panel bg-light panel-bordered">
  <div class="panel-heading bg-white">
    <h3 class="panel-title">Daftar Feedback yang ada pada Artikel dan Video</h3>
  </div>
  <div class="panel-body">
    @if($reviews->total())
      @foreach($reviews as $review)
        <div class="card card-block">
          <a class="h4" href="{{ route('post.show', $review->post->slug) }}">{{ $review->post->title }}</a>
          <table class="table table-bordered">
            <tr>
              <th>berkaitan dengan topik revewer</th>
              <th>Tingkat pemahaman</th>
              <th>Inspiratif</th>
              <th>Bahasa dan gaya</th>
              <th>Alur</th>
              <th>Rating</th>
            </tr>
            <tr>
              <td>{{ $review->sync_with_me ? 'Ya' : 'Tidak' }}</td>
              <td>{{ $review->understand }}</td>
              <td>{{ $review->inspiring }}</td>
              <td>{{ $review->language_style }}</td>
              <td>{{ $review->content_flow }}</td>
              <td>{{ round($review->rating, 2) }}</td>
            </tr>
          </table>
          <h4>Pesan</h4>
          <p>{{$review->message}}</p>
        </div>
      @endforeach
    @else
    <div class="text-center py-100">
      <h3 class="text-muted">Belum ada Feedback.</h3>
    </div>
    @endif
  </div>
  <div class="panel-footer">
    {{ $reviews->links() }}
  </div>
</div>
@endcomponent
@endsection