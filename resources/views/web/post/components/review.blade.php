<form action="{{ route('post.review.store', $post->id) }}" method="post" id="review">
  @csrf
  <h3>Feedback konstruktif</h3>
  <p class="mb-35">Feedback akan kami teruskan langsung ke Minitutor, tidak akan ditampilkan ke Publik, Feedback kamu sangat berharga untuk kemajuan kontent minitutor kedepannya.</p>
  <div class="row">
    <div class="col-lg-6">
      <div class="form-group">
        <label>Tingkat pemahaman kamu</label>
        <select name="understand" class="form-control @error('understand') is-invalid @enderror">
          <option disabled @if(!$review) selected @endif>Nilai</option>
          <option value="1" @if($review && $review->understand == 1) selected @endif>1</option>
          <option value="2" @if($review && $review->understand == 2) selected @endif>2</option>
          <option value="3" @if($review && $review->understand == 3) selected @endif>3</option>
          <option value="4" @if($review && $review->understand == 4) selected @endif>4</option>
          <option value="5" @if($review && $review->understand == 5) selected @endif>5</option>
        </select>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group">
        <label>Inspiratif</label>
        <select name="inspiring" class="form-control @error('inspiring') is-invalid @enderror">
          <option disabled @if(!$review) selected @endif>Nilai</option>
          <option value="1" @if($review && $review->inspiring == 1) selected @endif>1</option>
          <option value="2" @if($review && $review->inspiring == 2) selected @endif>2</option>
          <option value="3" @if($review && $review->inspiring == 3) selected @endif>3</option>
          <option value="4" @if($review && $review->inspiring == 4) selected @endif>4</option>
          <option value="5" @if($review && $review->inspiring == 5) selected @endif>5</option>
        </select>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group">
        <label>Bahasa dan gaya penyampaian kontent</label>
        <select name="language_style" class="form-control @error('language_style') is-invalid @enderror">
          <option disabled @if(!$review) selected @endif>Nilai</option>
          <option value="1" @if($review && $review->language_style == 1) selected @endif>1</option>
          <option value="2" @if($review && $review->language_style == 2) selected @endif>2</option>
          <option value="3" @if($review && $review->language_style == 3) selected @endif>3</option>
          <option value="4" @if($review && $review->language_style == 4) selected @endif>4</option>
          <option value="5" @if($review && $review->language_style == 5) selected @endif>5</option>
        </select>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="form-group">
        <label>Alur penyampaian kontent</label>
        <select name="content_flow" class="form-control @error('content_flow') is-invalid @enderror">
          <option disabled @if(!$review) selected @endif>Nilai</option>
          <option value="1" @if($review && $review->content_flow == 1) selected @endif>1</option>
          <option value="2" @if($review && $review->content_flow == 2) selected @endif>2</option>
          <option value="3" @if($review && $review->content_flow == 3) selected @endif>3</option>
          <option value="4" @if($review && $review->content_flow == 4) selected @endif>4</option>
          <option value="5" @if($review && $review->content_flow == 5) selected @endif>5</option>
        </select>
      </div>
    </div>
    
  </div>
  
  <div class="form-group">
    <label>Pesan</label>
    <textarea class="form-control @error('message') is-invalid @enderror" name="message" placeholder="Tuliskan pesan untuk MiniTutor">@if($review) {{$review->message}} @endif</textarea>
  </div>

  <div class="form-group">
    <div class="checkbox-custom checkbox-primary">
      <input type="checkbox" id="sync_with_me-check" name="sync_with_me" @if($review && $review->sync_with_me) checked @endif>
      <label for="sync_with_me-check">Apakah bidangmu berkaitan dengan topik diatas?</label>
    </div>
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down">
      <span class="ladda-label">Kirim</span>
    </button>
  </div>
</form>