<feedback-list inline-template>
  <div class="feedback-row {{ $inPanel ?? '' }}">
    <div class="feedback-row-info" v-if="!showDetail">
      <div class="feedback-row-left">
        <div class="user-pic">
          <a href="{{ route('users.show', $review->user->username) }}" class="avatar">
            <v-lazy-image
              class="avatar-holder"
              src="{{ $review->user->imageUrl() }}"
              src-placeholder="{{ asset('img/placeholder/avatar.png') }}"
              alt="{{ $review->user->username }}"
            ></v-lazy-image>
          </a>
        </div>
      </div>
      <div class="feedback-row-right">
        <h5 class="feedback-row-info-name"><a href="{{ route('users.show', $review->user->username) }}">{{ $review->user->name() }}</a></h5>
        <span class="feedback-row-info-date">{{ $review->created_at->diffForHumans() }}</span>
        <star-rating class="line-height-1 feedback-row-info-rating" :rating="{{ $review->rating }}" :read-only="true" :increment="0.01" :star-size="16" text-class="mt-0 font-weight-bold"></star-rating>
        <p class="feedback-row-info-message">{{ $review->message }}</p>
      </div>
    </div>
    <div class="feedback-row-detail" v-else>
      <table class="table table-bordered">
        <tr>
          <th>Nama</th>
          <td><a href="{{ route('users.show', $review->user->username) }}">{{ $review->user->name() }}</a></td>
        </tr>
        <tr>
          <th>Dibuat pada</th>
          <td>{{ $review->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
          <th>Berkaitan dengan reviewer</th>
          <td>{{ $review->sync_with_me ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
          <th>Tingkat pemahaman</th>
          <td>{{ $review->understand }}</td>
        </tr>
        <tr>
          <th>Inspiratif</th>
          <td>{{ $review->inspiring }}</td>
        </tr>
        <tr>
          <th>Bahasa dan gaya penyampaian</th>
          <td>{{ $review->language_style }}</td>
        </tr>
        <tr>
          <th>Alur kontent</th>
          <td>{{ $review->content_flow }}</td>
        </tr>
        <tr>
          <th>Total Rating</th>
          <td>{{ round($review->rating, 2) }}</td>
        </tr>
        <tr>
          <th>Pesan</th>
          <td>{{ $review->message }}</td>
        </tr>
      </table>
    </div>
    <div class="feedback-row-action">
      <button type="button" class="btn btn-default btn-sm btn-block" @click="showDetail = !showDetail">@{{ showDetail ? 'Tutup' : 'Detail' }}</button>
    </div>
  </div>
</feedback-list>