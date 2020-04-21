@extends('admin.layouts.app')
@section('title', 'dashboard')
@section('content')
<div class="panel panel-bordered">
  <div class="panel-heading">
    <h3 class="panel-title">Dashboard</h3>
  </div>
  <div class="panel-body">
    <form action="{{ route('admin.broadcast.mail.send') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="target">Broadcast Target</label>
        <select name="target" id="target" class="form-control">
          @foreach($targets as $key => $target)
            <option value="{{ $key }}">{{ $target['name'] }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="target">Subject</label>
        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="Subject" value="{{ old('subject') }}">
        @error('subject')
          <span class="invalid-feedback">{{ $message }}</span>
        @enderror
      </div>
      <div class="form-group" id="markdown-editor">
        <markdown-editor value="{{ old('body') }}" height="auto" v-model="marked"></markdown-editor>
        <textarea name="body" class="d-none">@{{ marked }}</textarea>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
          <span class="ladda-label">Kirim</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/markdown.js') }}"></script>
@endsection

