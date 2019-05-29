@extends('layouts.app')

@section('title', $type->title . ' - ' . config('app.name', 'Cinema'))

@section('content')

<div class="main-content">
    <h1>{{$type->title}}</h1>
    <div class="right-sidebar">
        <section class="content-block">
        <div class="content">
            @forelse($movies as $movie)
            <div class="card">
                <a href="{{route('video', $movie->slug)}}">
                    <div class="card-poster">
                        <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}"
                             alt="Постер к фильму '{{$movie->title}}'"
                             title="Постер к фильму '{{$movie->title}}'"/>
                    </div>
                    <div class="card-title">
                        {{$movie->title}}
                    </div>
                </a>
                <div class="card-raiting">{{$movie->kp_raiting / 10000}}</div>
            </div>
            @empty
            <div>Нет опубликованых фильмов!</div>
            @endforelse
        </div>
            </section>
        <aside>
            <div class="sidebar">
                <div class="title">Жанры</div>
                <ul class="unstyled">
                    @forelse($genres as $genre)
                    <li>
                        <a href="{{route('genre', ['type_slug' => $type->slug, 'genre_slug' => $genre->slug])}}">
                            {{$genre->title}}
                        </a>
                    </li>
                    @empty
                    <li>Нет жанров</li>
                    @endforelse
                </ul>
            </div>
        </aside>
    </div>
</div>

<ul class="pagination float-right">
    {{$movies->links()}}
</ul>

@endsection

