@extends('layouts.app')

@section('title', $movie->meta_title)
@section('meta_title', $movie->meta_title)
@section('meta_keyword', $movie->meta_keyword)
@section('meta_description', $movie->meta_description)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{$movie->title}}</h1>
            <p class="text-muted h3">{{$movie->title_en}}</p>
        </div>
        <div class="col-4">
            <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}" class="img-fluid" alt="Постер к фильму {{$movie->title}}" title="Постер к фильму {{$movie->title}}" />
        </div>
        <div class="col-8">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">{{$premiere}}</li>
                @if(count($countries))
                $delimeter = ', ';
                <li class="list-group-item">
                    @foreach($countries as $country)
                        {{$country->title. $delimeter}} 
                    @endforeach
                </li>
                @endif
                <li class="list-group-item">Porta ac consectetur ac</li>
                <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
        <hr>
        <p>{{$movie->description}}</p>
    </div>
</div>
@endsection
