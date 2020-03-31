<form action="{{ route('post.review.store', $post->id) }}" method="post" id="review">
  @csrf
  <h3 class="mb-35">Beri Ulasan</h3>
  <div class="form-group">
    <label>Jumlah bintang</label>
    <select name="rating" class="form-control">
      <option value="0" disabled @if(!$review) selected @endif>0</option>
      <option value="1" @if($review && $review->rating == 1) selected @endif>1</option>
      <option value="2" @if($review && $review->rating == 2) selected @endif>2</option>
      <option value="3" @if($review && $review->rating == 3) selected @endif>3</option>
      <option value="4" @if($review && $review->rating == 4) selected @endif>4</option>
      <option value="5" @if($review && $review->rating == 5) selected @endif>5</option>
    </select>
  </div>
  <div class="form-group">
    <label>Pesan</label>
    <textarea class="form-control" name="body" placeholder="Tuliskan pesan untuk MiniTutor">@if($review) {{$review->body}} @endif</textarea>
  </div>
  <div class="form-group">
    <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
      <span class="ladda-label">Kirim</span>
    </button>
  </div>
</form>