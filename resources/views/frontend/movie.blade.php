@extends('layouts.app')

@section('title', $movie->meta_title)
@section('meta_title', $movie->meta_title)
@section('meta_keyword', $movie->meta_keyword)
@section('meta_description', $movie->meta_description)

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{$movie->title}}</h1>
            <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}" class="img-fluid" alt="Постер к фильму {{$movie->title}}" title="Постер к фильму {{$movie->title}}" />
            <p>{{$movie->description}}</p>
            <hr>
        </div>
    </div>
</div>
@endsection
