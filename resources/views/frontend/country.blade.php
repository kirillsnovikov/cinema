@extends('layouts.app')

@section('title', $country->title . ' - CCO.CC')

@section('content')

<div class="container">
<div class="d-flex align-items-center mb-3">
    <p class="m-0 h4 text-capitalize">{{$country->title}}</p>
    <img class="ml-3"src="https://www.countryflags.io/{{$country->code_alpha2}}/flat/48.png">
    <p class="m-0"><small>({{$country->code_alpha2}})</small></p>
</div>
<div class="row">
    <div class="col-9">
        <div class="row">
            @forelse($movies as $movie)
            <div class="col-3 mb-4">
                <div class="card">
                    <!--<img src="{{asset('storage/poster/medium/'.$movie->image_name)}}" class="card-img-top" alt="Постер к фильму '{{$movie->title}}'" title="Постер к фильму '{{$movie->title}}'" />-->
                    <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}" class="card-img-top" alt="Постер к фильму '{{$movie->title}}'" title="Постер к фильму '{{$movie->title}}'" />
                    <div class="card-body">
                        <p class="card-title h5">{{$movie->title}}</p>
                        <p class="card-text">{!!str_limit($movie->description_short, 50)!!}</p>
                        <a href="{{route('video', $movie->slug)}}" class="btn btn-primary" title="Смотреть фильм">К просмотру...</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-danger" role="alert">
                    Нет опубликованых фильмов!
                </div>
            </div>
            @endforelse
        </div>
    </div>
    @forelse($countries as $country)
    @if($loop->first)
    <div class="col-3"><p class="h2">Все страны</p>
    @endif
        <div class="">
            <hr class="my-0">
            <a href="{{route('country', $country->slug)}}">
                <div class="d-flex justify-content-between align-items-center">
                    <p class="m-0 text-capitalize"><small>{{$country->title.' ('.$country->movies->count().')'}}</small></p>
                    <img class="ml-3"src="https://www.countryflags.io/{{$country->code_alpha2}}/flat/32.png">
                </div>
            </a>
        </div>
    @empty
    <div class="d-none">
    @endforelse
    </div>
    <ul class="pagination float-right">
        {{$movies->links()}}
    </ul>
</div>
@endsection

