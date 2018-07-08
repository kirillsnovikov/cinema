@extends('layouts.app')

@section('title', $genre->title . ' - CCO.CC')

@section('content')

<div class="container">
    <p class="h4 text-capitalize">{{$genre->title}}</p>
    <div class="row">
        @forelse($movies as $movie)
        <div class="col-2 mb-4">
            <div class="card">
                <img src="{{asset('storage/poster/'.$movie->image_name.'.'.$movie->image_ext)}}" class="card-img-top" alt="Постер к фильму '{{$movie->title}}'" title="Постер к фильму '{{$movie->title}}'" />
                <div class="card-body">
                    <p class="card-title h5">{{$movie->title}}</p>
                    <p class="card-text">{!!$movie->description_short!!}</p>
                    <a href="{{route('movie', $movie->slug)}}" class="btn btn-primary">К просмотру...</a>
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
    <ul class="pagination float-right">
        {{$movies->links()}}
    </ul>
</div>
@endsection