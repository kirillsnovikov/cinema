@extends('layouts.app')

@section('title', $genre->title . ' - CCO.CC')

@section('content')
<div class="main-content">
    <h1>{{$genre->title}}</h1>
    <div class="right-sidebar">
        @include('frontend.genre.particles.content')
        @include('frontend.genre.particles.sidebar')
    </div>
</div>
@endsection
