@extends('layouts.template')

@section('style')
  <link href="./css/main.css" rel="stylesheet">
@endsection

@section('content')
  <main class="main">
    <h1 class="main-h1">VK API</h1>
    <p class="main-text mod-name">Hi {{$user['first_name']}} {{$user['last_name']}}</p>
    <p class="main-text mod-id">id: {{$user['id']}}</p>
    <div class="main-img" style="background-image: url({{$user['photo_big']}});"></div>
  </main>
  <section class="friends">
    <p class="friends-text">Your friends</p>
    <ul class="friends-list">
      @foreach ($friends as $friend)
        <li class="friend">
          <div class="friend-img" style="background-image: url({{$friend['photo_200_orig']}});"></div>
          <div class="friend-block">
            <p class="friend-text">{{$friend['first_name']}}</p>
            <p class="friend-text">id: {{$friend['id']}}</p>
            <a href="https://vk.com/{{$friend['domain']}}" class="friend-a">Page</a>
          </div>
        </li>
      @endforeach
    </ul>
  </section>
@endsection