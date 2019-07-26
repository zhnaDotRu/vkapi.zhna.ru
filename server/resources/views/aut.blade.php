@extends('layouts.template')

@section('style')
  <link href="./css/aut.css" rel="stylesheet">
@endsection

@section('content')
  <main class="main">
    <h1 class="main-h1">VK API</h1>
    <a href="{{$url}}" class="button-aut">Aut vk</a>
  </main>
@endsection