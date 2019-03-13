@extends('layouts.app')

@section('title', 'Он-лайн сервис просмотра фильмов в хорошем качестве FullHD, HD720, HD1080')
@section('meta_title', 'Новинки лучших фильмов и сериалов смотреть он-лайн в хорошем качестве')
@section('meta_keyword', 'Фильмы онлайн, сериалы онлайн, новинки кино, онлайн бесплатно, в хорошем качестве, HD1080, HD720, FullHD')
@section('meta_description', 'Описание главной страницы')

@section('content')

<div class="container">
    <h1>Он-лайн сервис просмотра фильмов в хорошем качестве FullHD, HD720, HD1080' {{ config('app.name', 'Cinema') }}</h1>
    <div class="row">
        <h2 class="col-12">Новинки фильмов 2018-2019</h2>
        @forelse($films as $film)
        <div class="col-2 mb-4">
            <div class="card">
                <!--<img src="{{asset('storage/poster/medium/'.$film->image_name)}}" class="card-img-top" alt="Постер к фильму '{{$film->title}}'" title="Постер к фильму '{{$film->title}}'" />-->
                <img src="https://loremflickr.com/300/400/art/?random={{$film->image}}" class="card-img-top" alt="Постер к фильму '{{$film->title}}'" title="Постер к фильму '{{$film->title}}'" />
                <div class="card-body">
                    <p class="card-title h5">{{$film->title}}</p>
                    <p class="card-text">{!!str_limit($film->description_short, 50)!!}</p>
                    <a href="{{route('movie', $film->slug)}}" class="btn btn-primary" title="Смотреть фильм">К просмотру...</a>
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
    <div class="row">
        <h2 class="col-12">Новинки сериалов 2018-2019</h2>
        <!--<h3>{{ route('type') }}</h3>-->
        @forelse($serials as $serial)
        <div class="col-2 mb-4">
            <div class="card">
                <!--<img src="{{asset('storage/poster/medium/'.$serial->image_name)}}" class="card-img-top" alt="Постер к фильму '{{$serial->title}}'" title="Постер к фильму '{{$serial->title}}'" />-->
                <img src="https://loremflickr.com/300/400/art/?random={{$serial->image}}" class="card-img-top" alt="Постер к фильму '{{$serial->title}}'" title="Постер к фильму '{{$serial->title}}'" />
                <div class="card-body">
                    <p class="card-title h5">{{$serial->title}}</p>
                    <p class="card-text">{!!str_limit($serial->description_short, 50)!!}</p>
                    <a href="{{route('movie', $serial->slug)}}" class="btn btn-primary" title="Смотреть фильм">К просмотру...</a>
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

@endsection
