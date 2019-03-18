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
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Год</th>
                        <td>{{$premiere}}</td>
                    </tr>
                    @if(count($countries))
                    <tr>
                        <th scope="row">Страна</th>
                        <td>
                            @foreach($countries as $country)
                            {{(!$loop->last) ? $country->title . ', ' : $country->title}}
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($directors))
                    <tr>
                        <th scope="row">Режиссер</th>
                        <td>
                            @foreach($directors as $director)
                            <a href="{{route('person', $director->slug)}}">
                            {{(!$loop->last) ? $director->firstname . ' ' . $director->lastname . ', ' : $director->firstname . ' ' . $director->lastname}}
                            </a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($actors))
                    <tr>
                        <th scope="row">Актеры</th>
                        <td>
                            @foreach($actors as $actor)<a href="{{route('person', $actor->slug)}}">{{$actor->firstname . ' ' . $actor->lastname}}</a>@endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($genres))
                    <tr>
                        <th scope="row">Жанр</th>
                        <td>
                            @foreach($genres as $genre)
                            {{(!$loop->last) ? ucfirst($genre->title) . ', ' : ucfirst($genre->title)}}
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th scope="row">Время</th>
                        <td>{{date('G:i', mktime(0,$movie->duration)) . ' (' . $movie->duration . ' минут)'}}</td>
                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-start align-items-baseline">
                <div class="h3 mr-3">Кинопоиск:</div>
                <div class="">{{$movie->kp_raiting / 10000}}</div>
            </div>
            <div class="d-flex align-items-baseline">
                <div class="h3 mr-3">ImDB:</div>
                <div class="">{{$movie->imdb_raiting / 10000}}</div>
            </div>
        </div>
        <div class="col-12 d-flex flex-wrap mt-3">
            @forelse($actors as $actor)
            <div class="mr-2">
                <img src="https://loremflickr.com/100/150/face/?random={{$actor->image}}" class="rounded mx-auto d-block" alt="{{$actor->firstname.' '.$actor->lastname}}">
            </div>
            @empty
            Список актеров не найден
            @endforelse
        </div>
        <hr>
        <p class="p-3">{{$movie->description}}</p>
    </div>
</div>
@endsection
