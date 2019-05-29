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
            <section class="content-block">
                <div class="content">
                    <div class="poster">
                        <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}"
                             class="img-fluid" alt="Постер к фильму {{$movie->title}}"
                             title="Постер к фильму {{$movie->title}}" />
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
                        <div class="raiting">
                            <div>Кинопоиск: {{$movie->kp_raiting / 10000}}</div>
                            <div>IMDb: {{$movie->imdb_raiting / 10000}}</div>
                        </div>
                        <div class="description">{{$movie->description}}</div>
                        <div class="player">
                            <img src="https://cdn.pixabay.com/photo/2018/04/11/19/48/player-3311600_960_720.png" alt="">
                        </div>
                    </div>
                </div>
            </section>
            <aside>
                <div class="sidebar">

                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
