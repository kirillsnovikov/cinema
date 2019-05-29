@extends('layouts.app')

@section('title', $movie->meta_title)
@section('meta_title', $movie->meta_title)
@section('meta_keyword', $movie->meta_keyword)
@section('meta_description', $movie->meta_description)

@section('content')
<div class="main-content">
    <div class="content-layout">
        <h1>{{$movie->title}}</h1>
        <p class="title">{{$movie->title_en}}</p>
        <div class="right-sidebar">
            @include('frontend.movie.particles.content')
            @include('frontend.movie.particles.sidebar')
        </div>
    </div>
</div>
@endsection
