@extends('layouts.app')

@section('title', $type->title . ' - ' . config('app.name', 'Cinema'))

@section('content')

<div class="main-content">
    <h2>{{$type->title}}</h2>
    <div class="right-sidebar">
        <div class="catalog">
            @forelse($movies as $movie)
            <div class="card">
                <div class="card-poster">
                    <a href="{{route('video', $movie->slug)}}">
                        <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}"
                             alt="Постер к фильму '{{$movie->title}}'"
                             title="Постер к фильму '{{$movie->title}}'"/>
                    </a>
                </div>
                <div class="card-title">
                    <a href="{{route('video', $movie->slug)}}">
                        {{$movie->title}}
                    </a>
                </div>
                <div class="card-raiting">{{$movie->kp_raiting / 10000}}</div>
            </div>
            @empty
            <div>Нет опубликованых фильмов!</div>
            @endforelse
        </div>
        <div class="sidebar">
            Жанры
            @forelse($genres as $genre)
            <div>
                <a href="{{route('genre', ['type_slug' => $type->slug, 'genre_slug' => $genre->slug])}}">
                    <p class="m-0 px-2 text-capitalize">{{$genre->title}}</p>
                </a>
            </div>
            @empty
            <div>Пусто</div>
            @endforelse
        </div>
    </div>
</div>

<ul class="pagination float-right">
    {{$movies->links()}}
</ul>

@endsection

