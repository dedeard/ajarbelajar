@extends('layouts.app')

@section('content')
@component('components.minitutor_show', ['minitutor' => $minitutor])
  @foreach($data as $feedback)
  <feedback-list inline-template>
    <div class="feedback-row">
      <div v-if="!showDetail" class="feedback-row-info">
        <div class="feedback-row-left">
          <div class="user-pic">
            <a href="{{ route('users.show', $feedback->user->id) }}" class="avatar">
              <img class="avatar-holder" src="{{ $feedback->user->avatar_url }}" />
            </a>
          </div>
        </div>
        <div class="feedback-row-right">
          <h5 class="feedback-row-info-name">
            <a href="{{ route('users.show', $feedback->user->id) }}">
              {{ $feedback->user->name }}
            </a>
          </h5>
          <span class="feedback-row-info-date">{{ $feedback->created_at->diffForHumans() }}</span>
          <star-rating
            class="line-height-1 feedback-row-info-rating"
            :rating="{{ $feedback->rating }}"
            :read-only="true"
            :increment="0.01"
            :star-size="16"
            text-class="mt-0 font-weight-bold"
          ></star-rating>
          <p class="feedback-row-info-message">{{ $feedback->message }}</p>
        </div>
      </div>
      <div v-else class="feedback-row-detail">
        <table class="table table-bordered">
          <tr>
            <th>Nama</th>
            <td>
              <a href="{{ route('users.show', $feedback->user->id) }}">
                {{ $feedback->user->name }}
              </a>
            </td>
          </tr>
          <tr>
            <th>Dibuat pada</th>
            <td>{{ $feedback->created_at->format('y m d') }}</td>
          </tr>
          <tr>
            <th>Berkaitan dengan reviewer</th>
            <td>{{ $feedback->sync_with_me ? 'Ya' : 'Tidak' }}</td>
          </tr>
          <tr>
            <th>Tingkat pemahaman</th>
            <td>{{ $feedback->understand }}</td>
          </tr>
          <tr>
            <th>Inspiratif</th>
            <td>{{ $feedback->inspiring }}</td>
          </tr>
          <tr>
            <th>Bahasa dan gaya penyampaian</th>
            <td>{{ $feedback->language_style }}</td>
          </tr>
          <tr>
            <th>Alur konten</th>
            <td>{{ $feedback->content_flow }}</td>
          </tr>
          <tr>
            <th>Total rating</th>
            <td>{{ $feedback->rating }}</td>
          </tr>
          <tr>
            <th>Pesan</th>
            <td>{{ $feedback->message }}</td>
          </tr>
        </table>
      </div>
      <div class="feedback-row-action">
        <button
          type="button"
          class="btn btn-default btn-sm btn-block"
          @click="showDetail = !showDetail"
        >
          @{{ showDetail ? 'Tutup' : 'Detail' }}
        </button>
      </div>
    </div>
  </feedback-list>
  @endforeach
@endcomponent
@endsection
