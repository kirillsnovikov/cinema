@extends('admin.layouts.admin')

@section('content')

<div class="card-deck mt-3 text-white">
    <div class="card bg-success">
            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
        <div class="card-body">
            <h5 class="card-title">Жанры
                <span class="badge badge-light">{{$count_genres}}</span>
            </h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
            <a href="{{ route('admin.genre.index') }}" class="btn btn-outline-light">GoToEdit</a>
        </div>
        @foreach($genres as $genre)
        <div class="card-footer">
            <a href="{{route('admin.genre.edit', $genre)}}" class="text-white text-uppercase">
                {{$genre->title}}
                <span class="d-inline badge badge-light">{{$genre->movies()->count()}}</span>
            </a>
        </div>
        @endforeach
    </div>
    <div class="card bg-danger">
            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
        <div class="card-body">
            <h5 class="card-title">Фильмы
                <span class="badge badge-light">{{$count_movies}}</span>
            </h5>
            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
            <a href="{{ route('admin.movie.index') }}" class="btn btn-outline-light">GoToEdit</a>
        </div>
        @foreach($movies as $movie)
        <div class="card-footer">
            <a href="{{route('admin.movie.edit', $movie)}}" class="d-block text-white text-uppercase">
                {{$movie->title}}
                <em><small class="d-block text-capitalize">{{$movie->genres()->pluck('title')->implode(', ')}}</small></em>
            </a>
        </div>
        @endforeach
    </div>
</div>
<div class="card-deck mt-3 text-white">
    <div class="card bg-warning">
            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
        <div class="card-body">
            <h5 class="card-title">Персоны
                <span class="badge badge-light">{{$count_persons}}</span>
            </h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
            <button type="button" class="btn btn-outline-light">GoToEdit</button>
        </div>
        <div class="card-footer">
            <small>Last updated 3 mins ago</small>
        </div>
    </div>
    <div class="card bg-info">
            <!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
        <div class="card-body">
            <h5 class="card-title">Пользователи</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
            <button type="button" class="btn btn-outline-light">GoToEdit</button>
        </div>
        <div class="card-footer">
            <small>Last updated 3 mins ago</small>
        </div>
    </div>
</div>

@endsection