@extends('layouts.app')

@section('script:before')
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha512-v8ng/uGxkge3d1IJuEo6dJP8JViyvms0cly9pnbfRxT6/31c3dRWxIiwGnMSWwZjHKOuY3EVmijs7k1jz/9bLA==" crossorigin="anonymous"></script>

<script>
  console.log(io('ws://192.168.1.7:5000'))
</script>

@endsection
@section('content')

@endsection
