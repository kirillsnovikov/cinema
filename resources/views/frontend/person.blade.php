@extends('layouts.app')

@section('title', $person->meta_title)
@section('meta_title', $person->meta_title)
@section('meta_keyword', $person->meta_keyword)
@section('meta_description', $person->meta_description)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{$fullname}}</h1>
            <p class="text-muted h3">{{title_case($person->name_en)}}</p>
        </div>
        <div class="col-4">
            <img src="https://loremflickr.com/300/400/face/?random={{$person->image}}" class="img-fluid" alt="Фото {{$fullname}}" title="Фото {{$fullname}}" />
        </div>
        <div class="col-8">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Профессии</th>
                        <td>
                            @foreach($person->professions as $profession)
                            <a href="#">{{(!$loop->last) ? $profession->title . ',' : $profession->title}}</a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Рост</th>
                        <td>{{$person->tall / 100}} м</td>
                    </tr>
                    <tr>
                        <th scope="row">Дата рождения</th>
                        <td>{{$birth_date}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Место рождения</th>
                        <td>
                            <a href="{{route('country', $person->countryBirth->slug)}}">{{$person->countryBirth->title}}</a>
                        </td>
                    </tr>
                    @if(count($genres))
                    <tr>
                        <th scope="row">Жанры</th>
                        <td>
                            @foreach($genres as $genre)
                            <a href="#{{$genre->title}}редирект на поиск по персоне и жанру">{{(!$loop->last) ? title_case($genre->title) . ',' : title_case($genre->title)}}</a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <p class="p-3">{{$person->description}}</p>
        @forelse($director_movie as $movie)
            @if($loop->first)
            <div class="col p-3"><p class="h2">Режиссер</p>
            @endif
            <div class="">
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-stretch">
                    <div class="">
                        <div class="">
                            <a href="{{route('video', $movie->slug)}}"><p class="h5 m-0"><u>{{$movie->title}} ({{date('Y', strtotime($movie->premiere))}})</u></p></a>
                            <p class="m-0"><small class="text-muted">{{$movie->title_en}}</small></p>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <p class="m-0">Кинопоиск: <strong>{{$movie->kp_raiting}}</strong></p>
                            <p class="m-0">ImDB: <strong>{{$movie->imdb_raiting}}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="d-none">
            @endforelse
        </div>
        @forelse($actor_movie as $movie)
            @if($loop->first)
            <div class="col p-3"><p class="h2">Актер</p>
            @endif
            <div class="">
                <hr class="my-2">
                <div class="d-flex justify-content-between align-items-stretch">
                    <div class="">
                        <div class="">
                            <a href="{{route('video', $movie->slug)}}"><p class="h5 m-0"><u>{{$movie->title}} ({{date('Y', strtotime($movie->premiere))}})</u></p></a>
                            <p class="m-0"><small class="text-muted">{{$movie->title_en}}</small></p>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <p class="m-0">Кинопоиск: <strong>{{$movie->kp_raiting}}</strong></p>
                            <p class="m-0">ImDB: <strong>{{$movie->imdb_raiting}}</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
        <div class="d-none">
            @endforelse
        </div>
    </div>
</div>
@endsection
