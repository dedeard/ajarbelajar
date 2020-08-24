@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <form class="row" method="post" enctype="multipart/form-data" action="{{ route('articles.update', $article->id) }}">
    @csrf
    @method('PUT')
    <div class="col-lg-8">
      <div class="panel panel-bordered">
        <div class="panel-heading">
          <h3 class="panel-title">Body</h3>
          <hr class="m-0">
          <div class="panel-body">
            <App-Editorjs image-url="{{ route('api.admin.articles.upload.image', $article->id) }}" editor-body="{{ $article->body }}" />
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Hero</h3>
        </div>
        <div class="panel-body">
        <hero-chooser inline-template>
          <div class="hero-chooser">
            <img :src="url || '{{ $article->heroUrl()['thumb'] }}'" alt="" />
            <div class="chooser text-center pt-2">
              <label for="hero-chooser" class="btn btn-default btn-block m-0">@{{ name || 'Choose image' }}</label>
              <input id="hero-chooser" type="file" class="d-none" name="hero" @change="handleChange">
            </div>
          </div>
        </hero-chooser>
        </div>
      </div>
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Informasi</h3>
        </div>
        <div class="panel-body">
          <category-autocomplete :categories="{{json_encode($categories)}}" inline-template>
            <div class="form-group category-autocomplete">
              <label>Kategori</label>
              <input ref="input" id="autoComplete" placeholder="Kategori" type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') ?? $article->category ? $article->category->name : '' }}">
              @error('category')
                <div class="invalid-feedback">
                  <strong>{{ $message }}</strong>
                </div>
              @enderror
            </div>
          </category-autocomplete>

          <div class="form-group">
            <label>Judul</label>
            <input placeholder="Judul" type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') ?? $article->title }}">
            @error('title')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea placeholder="Deskripsi" name="description" class="form-control @error('description') is-invalid @enderror">{{  old('description') ?? $article->description }}</textarea>
            @error('description')
              <div class="invalid-feedback">
                <strong>{{ $message }}</strong>
              </div>
            @enderror
          </div>

          <div class="form-group">
            <div class="checkbox-custom checkbox-primary">
              <input type="checkbox" id="public" name="public" @if(old('public') ?? !$article->draf) checked @endif>
              <label for="public">Publikasikan artikel ini</label>
            </div>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection
