<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
use App\Person;
use App\Type;
//use Illuminate\Support\Carbon;

//use App\Http\Resources\Movie as MovieResource;
//use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        $films = Type::where('title', 'фильмы')->first();
        $serials = Type::where('title', 'сериалы')->first();
//        dd($genre->movies());
        return view('frontend.index', [
//            'movies' => Movie::where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
//            'films' => $films->movies()->where('published', 1)->orderBy('premiere', 'desc')->paginate(18),
            'films' => $films->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
            'serials' => $serials->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
        ]);
    }

    public function type($type_slug)
    {
        $type = Type::where('slug', $type_slug)->first();
        $genres = Genre::whereHas('movies', function ($query) use ($type) {
                    $query->where('type_id', $type->id);
                })
                ->where('published', 1)
                ->get();
//        dd($genres);
//        dd($type->genres()->get());
//        dd($genre->movies()->where('published', 1)->paginate(12));

        return view('frontend.type', [
            'type' => $type,
            'movies' => $type->movies()->where('published', 1)->orderBy('created_at', 'desc')->paginate(12),
            'genres' => $genres
        ]);
    }

    public function genre($type_slug, $genre_slug)
    {
        $type = Type::whereSlug($type_slug)->first();
        $genre = Genre::whereSlug($genre_slug)->first();
//        $movies = Movie::with('types:slug')->get();
        $movies = $genre->movies()
                ->where('type_id', $type->id)
                ->where('published', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
//        $movies = Movie::whereHas('types', function ($query) use ($param) {
//                    $query->where('slug', $param);
//                })
//                ->whereHas('genres', function ($query) use ($slug) {
//                    $query->where('slug', $slug);
//                })
//                ->where('published', 1)
//                ->orderBy('created_at', 'desc')
//                ->paginate(12);
//        dd($movies);
//        $movies_type = $type->movies()->with('genres')->get();
//        $movies_type = $type->movies()->with('genres')->get()->has('genres', '=', $slug)->get();
//        dd($movies_type->has('genres', '=', $slug));
//        $movies = [];
//        foreach ($movies_type as $movie) {
//            if ($movie->genres->where('slug', $slug)->first() != null) {
//                $movies[] = $movie;
//            }
//
//
//
////            dd($movie->has('genres', '=', $slug)->get());
////            $movies[] = $movie->has('genres', '=', $slug);
//        }
//        dd($movies);
//        dd($movies[145]->types->where('slug', $param));
//        dd($type->movies()->where('published', 1)->get());

        return view('frontend.genre', [
            'type' => $type,
            'genre' => $genre,
            'movies' => $movies
        ]);
    }

    public function video($video_slug)
    {
//        $type = Type::whereSlug($type_slug)->first();
        $movie = Movie::where('slug', $video_slug)
                ->where('published', 1)
                ->first();
//        $premiere = \Carbon\Carbon::
//        dd($premiere);
        return view('frontend.movie', [
            'movie' => $movie,
//            'premiere' => date('Y', strtotime($movie->premiere)),
            'premiere' => \Carbon\Carbon::parse($movie->premiere)->format('Y'),
            'actors' => $movie->actors()->get(),
            'directors' => $movie->directors()->get(),
            'genres' => $movie->genres()->get(),
            'countries' => $movie->countries()->get(),
            'token' => config('services.moonwalk.token'),
            'delimiter' => ', '
        ]);
    }
    
    
    public function person($person_slug)
    {
        $movie = Person::where('slug', $person_slug)
                ->where('published', 1)
                ->first();
//        $premiere = \Carbon\Carbon::
//        dd($premiere);
        return view('frontend.movie', [
            'movie' => $movie,
//            'premiere' => date('Y', strtotime($movie->premiere)),
            'premiere' => \Carbon\Carbon::parse($movie->premiere)->format('Y'),
            'actors' => $movie->actors()->get(),
            'directors' => $movie->directors()->get(),
            'genres' => $movie->genres()->get(),
            'countries' => $movie->countries()->get(),
            'token' => config('services.moonwalk.token'),
            'delimiter' => ''
        ]);
    }

}
