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
    <div class="card">
      <div class="card-header d-flex">
        <h3>Kirim Email Private</h3>
        <div class="my-auto ml-auto">
          <a href="{{ route('emails.broadcast') }}" class="btn btn-primary btn-sm">Broadcast Email</a>
        </div>
      </div>
      <div class="card-body">
        <form action="{{ route('emails.private') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email') }}">
            @error('email')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
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
