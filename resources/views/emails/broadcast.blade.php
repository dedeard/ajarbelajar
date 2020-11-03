@extends('layouts.app')

@section('style:after')
<link href="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.css">
<style>
  .fr-popup {
    z-index: 1095 !important;
  }
</style>
@endsection

@section('script:before')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@3.1.0/js/froala_editor.pkgd.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.3.0/mode/xml/xml.min.js"></script>
<script type="text/javascript" src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
@endsection
@section('script:after')
<script>
  var editor = new FroalaEditor('#froala', {
    imageManagerLoadURL: "{{ route('froala.image') }}",
    imageManagerDeleteURL: "{{ route('froala.image', ['_token' => csrf_token()]) }}",
    imageManagerDeleteMethod: 'DELETE',
    imageUploadURL: "{{ route('froala.image', ['_token' => csrf_token()]) }}",
    imageUploadMethod: 'POST',
  })
</script>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="panel panel-bordered">
      <div class="panel-heading">
        <h3 class="panel-title">Broadcast Email</h3>
        <div class="panel-actions">
          <a href="{{ route('emails.private') }}" class="btn btn-primary btn-sm">Kirim Email Private</a>
        </div>
      </div>
      <div class="panel-body">
        <form action="{{ route('emails.broadcast') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="target">Broadcast Target</label>
            <select name="target" id="target" class="form-control">
              @foreach($targets as $key => $target)
                <option value="{{ $key }}">{{ $target }}</option>
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
          <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="froala">{{ old('body') }}</textarea>
            @error('body')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary ladda-button" data-style="slide-down" data-plugin="ladda">
              <span class="ladda-label">Kirim</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
