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
            <div class="content">
                <div class="poster">
                    <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}" class="img-fluid" alt="Постер к фильму {{$movie->title}}" title="Постер к фильму {{$movie->title}}" />
                </div>
                <div class="properties">
                    <table>
                        <tbody>
                            <tr>
                                <th>Год</th>
                                <td>{{$premiere}}</td>
                            </tr>
                            @if(count($movie->countries))
                            <tr>
                                <th>Страна</th>
                                <td>
                                    @foreach($movie->countries as $country)
                                    <a href="{{route('country', $country->slug)}}">{{(!$loop->last) ? $country->title . ',' : $country->title}}</a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if(count($movie->directors))
                            <tr>
                                <th>Режиссер</th>
                                <td>
                                    @foreach($movie->directors as $director)
                                    <a href="{{route('person', $director->slug)}}">
                                        {{(!$loop->last) ? $director->firstname . ' ' . $director->lastname . ', ' : $director->firstname . ' ' . $director->lastname}}
                                    </a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if(count($movie->actors))
                            <tr>
                                <th>Актеры</th>
                                <td>
                                    @foreach($movie->actors as $actor)
                                    <a href="{{route('person', $actor->slug)}}">{{(!$loop->last) ? $actor->firstname . ' ' . $actor->lastname . ',' : $actor->firstname . ' ' . $actor->lastname}}</a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if(count($movie->genres))
                            <tr>
                                <th>Жанр</th>
                                <td>
                                    @foreach($movie->genres as $genre)
                                    <a href="{{route('genre', [$movie->type->slug, $genre->slug])}}">{{(!$loop->last) ? ucfirst($genre->title) . ',' : ucfirst($genre->title)}}</a>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if(isset($movie->duration))
                            <tr>
                                <th>Время</th>
                                <td>{{date('G\чi', mktime(0,$movie->duration)) . ' (' . $movie->duration . ' мин.)'}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div>Кинопоиск: {{$movie->kp_raiting / 10000}}</div>
                    <div>IMDb: {{$movie->imdb_raiting / 10000}}</div>
                    <div class="description">{{$movie->description}}</div>
                </div>
            </div>
            <div class="sidebar">

            </div>
        </div>
    </div>
</div>

<div class="container">
    <swiper-component></swiper-component>
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
                        <th>Год</th>
                        <td>{{$premiere}}</td>
                    </tr>
                    @if(count($movie->countries))
                    <tr>
                        <th>Страна</th>
                        <td>
                            @foreach($movie->countries as $country)
                            <a href="{{route('country', $country->slug)}}">{{(!$loop->last) ? $country->title . ',' : $country->title}}</a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($movie->directors))
                    <tr>
                        <th>Режиссер</th>
                        <td>
                            @foreach($movie->directors as $director)
                            <a href="{{route('person', $director->slug)}}">
                                {{(!$loop->last) ? $director->firstname . ' ' . $director->lastname . ', ' : $director->firstname . ' ' . $director->lastname}}
                            </a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($movie->actors))
                    <tr>
                        <th>Актеры</th>
                        <td>
                            @foreach($movie->actors as $actor)
                            <a href="{{route('person', $actor->slug)}}">{{(!$loop->last) ? $actor->firstname . ' ' . $actor->lastname . ',' : $actor->firstname . ' ' . $actor->lastname}}</a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(count($movie->genres))
                    <tr>
                        <th>Жанр</th>
                        <td>
                            @foreach($movie->genres as $genre)
                            <a href="{{route('genre', [$movie->type->slug, $genre->slug])}}">{{(!$loop->last) ? ucfirst($genre->title) . ',' : ucfirst($genre->title)}}</a>
                            @endforeach
                        </td>
                    </tr>
                    @endif
                    @if(isset($movie->duration))
                    <tr>
                        <th>Время</th>
                        <td>{{date('G\чi', mktime(0,$movie->duration)) . ' (' . $movie->duration . ' мин.)'}}</td>
                    </tr>
                    @endif
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
            @forelse($movie->actors as $actor)
            <a href="{{route('person', $actor->slug)}}">
                <div class="mr-2 mb-2">
                    <img src="https://loremflickr.com/100/150/face/?random={{$actor->image}}" class="rounded mx-auto d-block" alt="{{$actor->firstname.' '.$actor->lastname}}" title="{{$actor->firstname.' '.$actor->lastname}}">
                </div>
            </a>
            @empty
            Список актеров не найден
            @endforelse
        </div>
        <hr>
        <p class="p-3">{{$movie->description}}</p>
    </div>
</div>
@endsection
