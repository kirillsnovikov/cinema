@extends('layouts.app')

@section('title', $movie->meta_title)
@section('meta_keyword', $movie->meta_keyword)
@section('meta_description', $movie->meta_description)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{$movie->title}}</h1>
            <img src="{{asset('storage/poster/medium/'.$movie->image_name)}}" class="img-fluid" alt="Постер к фильму '{{$movie->title}}'" title="Постер к фильму '{{$movie->title}}'" />
            <p>{!!$movie->description!!}</p>
        </div>
    </div>
</div>
@endsection
