@extends('web.layouts.app')
@section('content')
<div class="container-fluid mt-15">
    @include('web.partials.popular-video-lg')
    <div class="my-20"></div>
    @include('web.partials.new-videos')
    <div class="my-20"></div>
    @include('web.partials.popular-categories')
    <div class="my-20"></div>
    @include('web.partials.most-minitutor-point')
    <div class="my-20"></div>
    @include('web.partials.post-user-minitutor-count')
    <div class="my-20"></div>
</div>
@endsection
