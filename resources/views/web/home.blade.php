@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
    @include('web.partials.popular-video-lg')
    @include('web.partials.new-videos')
    @include('web.partials.popular-categories')
</div>
@endsection
