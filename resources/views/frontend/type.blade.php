@extends('layouts.app')

@section('title', $type->title . ' - CCO.CC')

@section('content')

<div class="container">
    <p class="h4 text-capitalize">{{$type->title}}</p>
    <div class="row">
        <div class="col-10">
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
        <div class="col-2">
            @foreach($genres as $genre)
            <div class="list-group list-group-flush">
                <a href="{{route('genre', ['type_slug' => $type->slug, 'genre_slug' => $genre->slug])}}" class="list-group-item list-group-item-action">{{$genre->title}}</a>
            </div>
            @endforeach
        </div>
    </div>
    <ul class="pagination float-right">
        {{$movies->links()}}
    </ul>
</div>
@endsection

